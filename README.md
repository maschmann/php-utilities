php-utilities
=============
[![Build Status](https://travis-ci.org/maschmann/php-utilities.png?branch=master)](https://travis-ci.org/maschmann/php-utilities)
[![phpci build status](http://phpci.br0ken.de/build-status/image/9)](http://phpci.br0ken.de)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maschmann/php-utilities/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maschmann/php-utilities/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/maschmann/php-utilities/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/maschmann/php-utilities/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8c7f40ea-df80-4efe-a2e7-e3239c4805a0/mini.png)](https://insight.sensiolabs.com/projects/8c7f40ea-df80-4efe-a2e7-e3239c4805a0)

## About
This library is all about helping with the common little problems like having a type of object to inherit from with an internal data storage to turn to a json or array, ... 

## Usage
A lot of examples on how to use the classes can be found in the UnitTests. The whole collection is extensively tested and therefore quite stable.
Feel free to contribute, suggest changes or help make it better.

## Contents
You'll get following groups of classes which are interdependent

### Data
This part consists of two distinct classes:
* Data is a data store where you can easily store and retrieve data.
* DataCollection ist a container to house items like objects, iterable.

### Config
Here you get a static factory which is able to produce three types of configuration objects, based on Data class. All config objects take yaml files as source and provide easy access via get/set methods. See UnitTests for examples.
Available types are:
* ConfigDefault - basic config object, stores the yaml content "as is", provides get/set.
* ConfigEnv - provides the possibility to get an environment-merged config. Based on the currently provided env, you'll have e.g. prod -> dev merged, with prod node as a master.
* ConfigTimer is a specialised for of config to provide pre-generated DateTime objects for the Timer class.

### Timer
Provides functionality to check if there's a current holiday, has configurable "timers" to check uf e.g. your hotline should be available etc.
Extensive examples can be found within both, the TestData and UnitTests :-)

### Test
TestData is just a helper for providing configurations for either Config and Timer. Have a look for YAML config examples.
