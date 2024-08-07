#bin/composer req phpstan/phpstan squizlabs/php_codesniffer magento/magento-coding-standard

git checkout develop
git pull origin develop || exit 1
git branch
git status

# partially run phpstan
export CMDTEST="bin/test_run.loc.sh"

git log --name-only |egrep '\.php'|grep -v 'app/etc/config.php'|head -n5|tail -r|awk '{ print "[ -f "$1" ] && (echo \"TEST NEXT FILE:\"; echo "$1"; php vendor/bin/phpmd "$1" ansi .//dev/tests/static/testsuite/Magento/Test/Php/_files/phpmd/ruleset.xml; php vendor/bin/phpcs --standard=Magento2  "$1"; php vendor/bin/phpstan analyse --level=4 "$1";)" }' > $CMDTEST; chmod 755 $CMDTEST
$CMDTEST



find app/ -type d -name 'Unit' | awk '{ print "Running tests in "$0; system("vendor/bin/phpunit -c dev/tests/unit/phpunit.xml "$0" --verbose"); }'



php -d memory_limit=2G bin/magento setup:di:compile


echo "##"
echo "## Run Tests in Docker"
cat bin/tests/runtime-tests.sh
