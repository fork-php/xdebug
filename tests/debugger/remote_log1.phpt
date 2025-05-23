--TEST--
Test for Xdebug's remote log (can not connect, no remote callback)
--SKIPIF--
<?php
require __DIR__ . '/../utils.inc';
check_reqs('dbgp; !win');
?>
--INI--
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.log={TMPFILE:remote-log1.txt}
xdebug.log_level=20
xdebug.discover_client_host=0
xdebug.client_host=doesnotexist
xdebug.client_port=9002
xdebug.control_socket=off
--FILE--
<?php
require_once __DIR__ . '/../utils.inc';

echo strlen("foo"), "\n";
echo file_get_contents(getTmpFile('remote-log1.txt'));
unlink(getTmpFile('remote-log1.txt'));
?>
--EXPECTF--
3
[%d] Log opened at %d-%d-%d %d:%d:%d.%d
[%d] [Step Debug] INFO: Connecting to configured address/port: doesnotexist:9002.
[%d] [Step Debug] WARN: Creating socket for 'doesnotexist:9002', getaddrinfo: %s.
[%d] [Step Debug] ERR: Could not connect to debugging client. Tried: doesnotexist:9002 (through xdebug.client_host/xdebug.client_port).
