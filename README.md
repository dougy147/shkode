Serve your current coding buffer to a live-updated webpage.

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

# Configure nginx server side

```console
# /etc/nginx/nginx.conf
http {
    ...
    large_client_header_buffers 10 128k;
    ...
}
```

# TODO

- [ ] handle special characters (avoid "Wide chars" failure)
- [ ] add syntax highlighting (syntax.css)
- [ ] auto-clean of unused files server side
