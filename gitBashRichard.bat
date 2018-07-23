cd c:\wamp64\www\csfrontend

git status

git add .

set /p commit=commit message:

git commit -m "%commit%"

git pull

git push