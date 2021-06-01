## KASKO ip-info API

Simple Ip-Info API implementation. To request data from [Ip-info](https://ipinfo.io/) command can be used:

```
bin/console ip-info:request
```

### Description
Command has dialogs built into it. No parameters should be provided to it. Dialogs will ask for **IP address**, **Auth Token**, **Filter** and Display preferences (Write to file/Display in CLI). In case of error with saving (wrong file path etc), command itself will provide options to resolve user made error.  

### How to use
There are couple of commands made for docker users to make life easier. Execute from command line:

* Start the environment:
```
make
```
* Make sure that all the containers are up and working (You should see two of them):
```
make ps
```
* SSH into container:
```
make ssh
```
* Once inside container, execute:
```
bin/console ip-info:request
```

* To execute unit tests, exit container:
```
exit
```
and execute tests:
```
make test-unit
```

### Things to improve

* Very poor test coverage
* Command should be refactored to some kind of journey thing
