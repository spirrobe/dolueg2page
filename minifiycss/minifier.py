#!/usr/bin/python3
import os
import requests

quiet=True

url = 'https://cssminifier.com/raw'

path='/media/mcr/html/dolueg2'
cssfolder='layout'

cssfiles = os.listdir(os.sep.join([path, cssfolder]))
cssfiles = [i for i in cssfiles if i.endswith('.css') and not i.endswith('_min.css')]

print(cssfiles)

for cssfile in cssfiles:
    with open(os.sep.join([path, cssfolder, cssfile]), 'r') as fo:
        cssfilecontent = fo.read()

    data = {'input': cssfilecontent}

    response = requests.post(url, data=data)

    with open(os.sep.join([path, cssfolder, cssfile.replace('.css','_min.css')]), 'w') as fo:
        fo.write(response.text)

    if not quiet:
        print(response.text)
