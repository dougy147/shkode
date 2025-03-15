Stream your code to a live-updated webpage (also see [https://shkode.nopub.club](https://shkode.nopub.club)).

# Use with Perl script

Download `shkode` Perl script, then:

```console
$ chmod +x ./shkode
$ ./shkode /path/to/your/code.py
[INFO] Serving "code.py" to "zWPeQt4wgj6S4oj".
[INFO] Access live code here: https://shkode.nopub.club/@/zWPeQt4wgj6S4oj/
```

Go to indicated URL to see your code live.

# Use from Bash

```bash
file=/path/to/your/code.rs
ur_pagename=MY_OWN_PAGE # make this unique
while :; do
    encoded=$(base64 $file -w 0)
    curl -s https://shkode.nopub.club -G --data-urlencode "code=$encoded" -d "page=$ur_pagename"
    sleep 5
done
```

Go to `https://shkode.nopub.club/@/MY_OWN_PAGE` to see your code live.

# For nerds

Some details on how to deploy your own `shkode` server.

```console
# server side
$ git clone https://github.com/dougy147/shkode
$ cd ./shkode
$ docker compose up -d
# streamer side
$ ./shkode file.txt
[INFO] Serving "file.txt" to "z747SLYJ2rDRyLe".
[INFO] Access live code here: https://shkode.nopub.club/@/z747SLYJ2rDRyLe/
```

Doc to come (or not...).

# TODO

- [ ] handle special characters (avoid "Wide chars" failure)
- [ ] add syntax highlighting (syntax.css)
- [ ] auto-clean of unused files server side
