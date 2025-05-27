@echo off
echo Generating code coverage report
set XDEBUG_MODE=coverage
vendor\bin\phpunit --coverage-html build\coverage
echo.
echo If successful, the coverage report is available at: build\coverage\index.html
