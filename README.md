<!--Stream your code to a [live-refreshed webpage](https://shkode.nopub.club).-->
<p align="center">
<a href="https://shkode.nopub.club">
<img src="https://raw.githubusercontent.com/dougy147/shkode/master/assets/header.png" width="80%" />
</a>
</p>

>[!NOTE]
> This was a quick experiment, don't expect much.

# Use shkode

>[!CAUTION]
> Your files are going public.
> Don't share any private information obviously.

## Dedicated script

Get [shkode](https://raw.githubusercontent.com/dougy147/shkode/refs/heads/master/docker/data/shkode) script from this repo, or from our example website [here](https://shkode.nopub.club/shkode).

```console
$ wget https://raw.githubusercontent.com/dougy147/shkode/refs/heads/master/docker/data/shkode
$ chmod +x ./shkode
$ ./shkode /path/to/your/code.py
[INFO] Serving "code.py" here:
[INFO] https://shkode.nopub.club/@/zWPeQt4wgj6S4oj/
```

Go to indicated URL to see your code live.

## Bash

Let this script run:

```bash
file=/path/to/your/code.rs
ur_pagename=MY_OWN_PAGE # make this unique
while :; do
    encoded=$(base64 $file -w 0)
    curl -s https://shkode.nopub.club -G --data-urlencode "code=$encoded" -d "page=$ur_pagename"
    sleep 5
done
```

And go to `https://shkode.nopub.club/@/MY_OWN_PAGE/` to see your code live.

# Deploy your own instance

To start your own `shkode` server, follow along those lines:

```console
# server side
$ git clone https://github.com/dougy147/shkode
$ cd ./shkode
$ docker compose up -d
```

The `./data/` folder is exposed on port `13337`.

# TODO

- [ ] syntax highlighting (syntax.css)
- [ ] handle special characters (avoid "Wide chars" failure)
- [ ] select server's DNS

# DONE

- [x] auto-clean of unused files server side (~15min)
- [x] max size of uploaded code ~`23500`bytes
- [x] limited to `10` simultaneous users (change this in [source code](https://github.com/dougy147/shkode/blob/master/docker/data/shkode))


>[!TIP]
> No reward for discovering security issues without acknowledging them <|:^)
