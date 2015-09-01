BugMeTasker is a script that if run on cron will popup and ask you what you have been doing so you can quickly mark off what you worked on.

It tracks activity in 15 min increments and when run always display the current tally

to have it run have cron run the bmt.php script with the first param cron every 15 mins
    */15 * * * * php /FULL/PATH/bugmetasker/bmt.php cron

also you will have to run the command each morning so you can start it.

There is also an alferdworkflow in the directory BugMeTracker.alferdworkflow that adds a bmt command to alferd
