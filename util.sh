#!/bin/bash

case "$1" in
"dev")
  directory_basename=${PWD##*/}
  if ! tmux has-session -t "$directory_basename"
    then
    names=("container" "make" "routes" "controllers" "views" "migrations" "free" "php")
    commands=("cd ${PWD}; make up-a" "cd ${PWD}" "cd ${PWD}/routes" "cd ${PWD}/app/Http" "cd ${PWD}/resources/views" "cd ${PWD}/database/migrations" "cd ${PWD}" "cd ${PWD}/; sleep 10; make connect-php")
    tmux new-session -s "$directory_basename" -n ${names[1]} -d
    for i in ${!names[@]}; do
        tmux new-window -t "$directory_basename":$i -n ${names[$i]}
        tmux send-keys -t "$directory_basename":$i.0 "${commands[$i]}" C-m
    done
  fi
    tmux select-window -t "$directory_basename":1.0
    tmux attach -t "$directory_basename"
  ;;
"connect-php")
    dirname=$(pwd | awk -F'/' '{print $NF}')
	docker exec  -it $dirname-php-1 bash
    ;;
"delete-db")
    dirname=$(pwd | awk -F'/' '{print $NF}')
	docker run --rm -v ${dirname}_postgress-data:/data/ ubuntu /bin/sh -c "rm -rf /data/*"
    ;;
"connect-container")
    printf "connection"
    ;;
"migrate-new")
	read -p "migration name:" migration
	read -p "table name:" table
    docker compose exec php php artisan make:migration $migration --table=$table
    ;;
"tmux-old")
    # tmux attach -t "$directory_basename"
    # tmux new-session -s "$directory_basename" -n Server -d

    # tmux new-window -t "$directory_basename":1 -n container
    # tmux new-window -t "$directory_basename":2 -n routes
    # tmux new-window -t "$directory_basename":3 -n controllers
    # tmux new-window -t "$directory_basename":4 -n views
    # tmux new-window -t "$directory_basename":5 -n migrations
    # tmux new-window -t "$directory_basename":6 -n make
    # tmux new-window -t "$directory_basename":7 -n free
    # # # run some command in the first window
    # # if [ -z "$1" ]
    # # then
    # #     tmux send-keys -t "$directory_basename":0.0 "cd ${PWD}" C-m
    # # else
    # #     tmux send-keys -t "$directory_basename":0.0 "cd ${PWD} && ${1}" C-m
    # # fi
    # tmux send-keys -t "$directory_basename":1.0 "cd ${PWD}" C-m
    # tmux send-keys -t "$directory_basename":1.0 "make up-a" C-m
    # tmux send-keys -t "$directory_basename":2.0 "cd ${PWD}/routes" C-m
    # tmux send-keys -t "$directory_basename":3.0 "cd ${PWD}/app/Http" C-m
    # tmux send-keys -t "$directory_basename":4.0 "cd ${PWD}/resources/views" C-m
    # tmux send-keys -t "$directory_basename":5.0 "cd ${PWD}/database/migrations" C-m
    # tmux send-keys -t "$directory_basename":6.0 "cd ${PWD}" C-m
    # tmux send-keys -t "$directory_basename":7.0 "cd ${PWD}" C-m
    # tmux select-window -t "$directory_basename":0.0

    ;;
*)
	echo "invalid first argument"
	;;
esac
