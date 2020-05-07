### var_list.php
Change the array $availablevars to your needs in var_list.php

Underscores seperate the different categories for variables (stations are found in a seperate stat_list.php in the campaign folders)

The letter in the php array designates what is searched for, i.e. _a_
while the value designates the name that is used to display it, i.e. Temperature and rel. Humidity

Change according to your needs and wished. Order of appearance is array order. Letters do not have to follow alphabetical ordering

```PHP

    $availablevars = ['a'=>'Temperature',
                      'b'=>'Status',
                      'x'=>'Other',
                      ];
```
