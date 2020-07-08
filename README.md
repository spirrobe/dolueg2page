# Homepage dolueg2
Set up your website to look like [dolueg2](https://mcr.unibas.ch/dolueg2/index.php?project=overview) of the Atmospheric Sciences at the University of Basel.

To create/find figures to fill dolueg, refer to the figure repository [dolueg2figures](https://github.com/spirrobe/dolueg2figures)

# Needed adjustments/"installation"
The website here is mostly skeleton, i.e. it contains no figures but the required scripts and framework

## Layout & Visual identity
We recommend to adjust the CSS files in "layout" to create your own visual identity and the file in "logo" to use your own logo. After a change in the CSS, the file should be minimised with the python script in "minifycss", or if you wish you can change the line in in index.php that reads 
<link rel="stylesheet" type="text/css" href="layout/dolueg_min.css">
to
<link rel="stylesheet" type="text/css" href="layout/dolueg.css">

## Setting up the automatic figure display
Other required adjustmens are these two types of file:
- "proj_list.php" in "projects" (contains all your campaigns/regional settings that you would like to see/display) and the tabs on top in the menu, e.g.
  - Tabs in them menu are $availablectabs = ['overview'=>'Overview', 'control'=>'Control', ];
  - Campaigns are $availablecampaigns= ['template'=>'Test', ];
  - Take note that you can have projects for yourself by testing in folders that then do not appear in the menu can be entered in the URL (replacing overview with the folder name for example) and then checked for suitability
- "stat_list.php" in the campaigns relevant folder, i.e. "projects/template/stat_list.php" contains the names you want to associate with the stations number, e.g.
- $stations = ['1'=>'Teststation', ];

## Setting up overview 
Overview relies on directly editable text files that are found in projects/overview. The default files contained within are

1. current values as table with two figures
2. a forecast of today for our mainlocation (basel) that was setup via https://www.meteoblue.com/en/user/account/index  via the so-called MeteoTV (free of charge but requires an accounts). Adjust the URL of the iframe in the file to make it your own
3. a forecast for the next five days (again basel, same way as abovein 2.). Adjust the URL of the iframe in the file to make it your own
4. the windfield forecast centered on based created via https://embed.windy.com/. Adjust the URL in the file according to your needs
5. About us and the lab, including contact info, explanation of navigation and purpose of the page. Change as needed

## Setting up the control
The control of the dataflow relies on a python script creating the needed table from a calibration file. See the relevant article in BAMS for more details. The webserver includes any php file in the "projects/control" folder. The format within each file is very simple and contains a table with one header (creation time of file), seven columns and as many rows as calibration files have been set to be combined in one control file. The columns are from left to right:

1. Name of station
2. The last time the datafile has been modified
3. The difference from "now" to when the modification occurred
4. The time of the last record in the datafile
5. The difference from "now" to the last record
6. The last entry in the database of relevant timeseries
7. The difference from "now" to the last entry in the database

Tooltips for each columns show the datafile, the calibration file and which timeseries are lagging the most.
The respective time differences are color coded by the amount of passed hours with user-settable delays (<13 H good, > 25H bad , between the two warning as default). 
These tables allow for easier debugging of problems with the dataflow. Examples:
- Columns 2/3 are bad -> The connection to the station is probably broken -> fix connection
- Coumns 4/5 are bad -> A part of the station/device is broken -> Look for columns 7 which device it might be and fix it
- Columns 6/7 are bad -> Device is broken and delivers bad or out of range values/Something changed and the calibration does no longer work (datafile moved, output on logger, ..) -> Look at column 7 to find out which timeseries are affected and investigate the problem

For the creation of the tables refer to the [Figure Repository](https://github.com/spirrobe/dolueg2figures)

 

# Dependencies
- Running webserver with
  - PHP
  - JavaScript enabled in browser
  - access to the file system to copy/move figures

# Tracking of users and their behaviour
We do not track users in any way. If you have need for tracking you will have to add the relevant changes yourself 
