#!/bin/sh

if ! grep -qs '/dev/sdb1' /proc/mounts; then
    if ! file -sL /dev/sdb1 | grep -s 'ext4'; then
        if ! fdisk -l | grep -qs '/dev/sdb1'; then
            echo "Partitionning data disk"
            echo -e "o\nn\np\n1\n\n\nw" | fdisk /dev/sdb
        fi

        echo "Formatting data disk"
        mkfs.ext4 /dev/sdb1
    fi

    echo "Mount data disk partition on /data"
    mkdir -p /data
    mount -t ext4 /dev/sdb1 /data
fi
