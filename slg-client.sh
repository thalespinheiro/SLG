#!/bin/sh
base_url="http://slg.kurtkraut.net/api"
content_from_server=$(mktemp)
content_from_task=$(mktemp)
version="0.1"

### Functions ###
clioutput ()
{
	#Adds timestamps to message. Used for default CLI output.
	time=$(date +%X)
	echo "($time) $*"
}

mtrtask ()
{
	mtr --raw --no-dns -c 3 $2 > $content_from_task
	if test $? -eq 0
	then
		clioutput "Sending results of $1 to central server."
		wget --user-agent="slg-client v$version" --base="$base_url/incoming.php" --post-file="$content_from_task"
	else
		clioutput "mtr exited with an error. See output above."
	fi
}

### Procedural Logic ###

#Fetching the jobs list.
clioutput "Querying central server for more jobs."
wget --quiet --user-agent="slg-client v$version" --output-document=$content_from_server --timeout=30 $base_url/jobs.php 

#Parsing the jobs list from the central server.
while read line
do
	param1=$(echo $line | cut -d"," -f 1)
	param2=$(echo $line | cut -d"," -f 2)
	param3=$(echo $line | cut -d"," -f 3)
	if test $param1 = "0"
	then
		clioutput "No jobs to be done. Exiting."
		exit 0
	fi
	if test $param2 = "mtr"
	then
		clioutput "Found mtr job ($param1) to target $param3. Performing it right now."
		mtrtask $param1 $param3
	fi
done < $content_from_server 

#Cleaning temporarying files
rm -f $content_from_server
rm -f $content_from_task
