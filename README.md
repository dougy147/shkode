| NOTE                              |
|:----------------------------------|
| **this is a personal experiment** |

Stream your code to a [live-updated webpage](https://shkode.nopub.club).

- Uploaded code is cleaned when >15 minutes old
- Max size of uploaded code ~`23500`bytes
- Limited to `10` simultaneous users

# Use shkode

## with dedicated script

```console
$ wget https://shkode.nopub.club/shkode
$ chmod +x ./shkode
$ ./shkode /path/to/your/code.py
[INFO] Serving "code.py" here:
[INFO] https://shkode.nopub.club/@/zWPeQt4wgj6S4oj/
```

Go to indicated URL to see your code live.

# with Bash

```bash
file=/path/to/your/code.rs
ur_pagename=MY_OWN_PAGE # make this unique
while :; do
    encoded=$(base64 $file -w 0)
    curl -s https://shkode.nopub.club -G --data-urlencode "code=$encoded" -d "page=$ur_pagename"
    sleep 5
done
```

Go to `https://shkode.nopub.club/@/MY_OWN_PAGE/` to see your code live.

# for nerds

Some details on how to deploy your own `shkode` server.

```console
# server side
$ git clone https://github.com/dougy147/shkode
$ cd ./shkode
$ docker compose up -d
# streamer side
$ ./shkode file.txt
[INFO] Serving "file.txt" here:
[INFO] https://shkode.nopub.club/@/z747SLYJ2rDRyLe/
```

Doc to come (or not...).

# TODO

- [ ] handle special characters (avoid "Wide chars" failure)
- [ ] add syntax highlighting (syntax.css)
- [ ] auto-clean of unused files server side
