<?php
/**
 * @namespace Asm\Test
 */
namespace Asm\Test;

/**
 * Class TestData
 *
 * @package Asm\Test
 * @author marc aschmann <maschmann@gmail.com>
 */
class TestData
{
    /**
     * provide yaml schema testdata
     *
     * @return string
     */
    public static function getYamlConfigFile()
    {
        return <<<EOT
prod:
    testkey_1: 'testvalue'
    testkey_2:
        - dummy1
        - dummy2
        - dummy3
    testkey_3:
        subkey_1: subvalue1
        subkey_2: 123
        subkey_3: ~

stage: []
test: []
dev:
    testkey_2:
        - 25
        - 69
EOT;
    }

    /**
     * testdata/default config for german holiday-based timers
     *
     * @return string
     */
    public static function getYamlTimerConfigFile()
    {
        return <<<EOT
timers:
    example_timer_config_1:
        interval:
            -               [ "2013-02-06" ] # 00:00:00 - 23:59:59
            -               [ "2013-04-24 00:00:01", "2013-04-28 23:59:59" ]

    example_timer_config_2:
        interval:
            -               [ "2013-02-28" ] # only works for this day, 00:00:00 - 23:59:59
            -               [ "2013-04-24" ]

    example_timer_config_3:
        day:                [ monday, tuesday, wednesday, thursday ] # works weekdays 00:00:00 - 23:59:59

    example_timer_config_4:
        day:                [ monday ]                  # works only mondays
        time:
            - [ "01:05:00", "17:00:00" ]  # from 01:05:00 to 17:00:00

    example_timer_config_5:
        time:
            - [ "01:05:00", "17:00:00" ]  # from 01:05:00 to 17:00:00

    example_timer_config_6:
        holiday:
            use_gerneral:   true                        # if false, uses separate holidays conf
            additional:     [ sub, 1 ]                  # add or subract n days to holiday to create range
            interval:
                - [ "16:00:00", "16:00:00" ]  # start and end time

    general_shipping_promise:
        holiday:
            use_general:    true
            additional:     [ sub, 1 ]                  # add or subract n days to holiday to create range
            interval:
                - [ "16:00:00", "16:00:00" ]  # start and end time
        day:                [ monday, tuesday, wednesday, thursday, friday, sunday  ]

    shipping_promise_sunday:
        day:                [ sunday ] # works only sundays
        time:
            - [ "00:00:01", "16:00:00" ]  # from 00:00:01 to 16:00:00



holidays:
    - [ "2014-10-29" ] # can be intervals or single dates/DateTime touples

general_holidays: # german (baden-wuerttemberg) holidays
    - { name: "Neujahr",                   value: [ "01", "01" ],   type: fix }
    - { name: "heilige drei Koenige",      value: [ "01", "06" ],   type: fix }
    - { name: "Karfreitag",                value: [ sub, 2 ],       type: var }
    - { name: "Ostermontag",               value: [ add, 1 ],       type: var }
    - { name: "Tag der Arbeit",            value: [ "05", "01" ],   type: fix }
    - { name: "Christi Himmelfahrt",       value: [ add, 39],       type: var }
    - { name: "Pfingstmontag",             value: [ add, 50],       type: var }
    - { name: "Fronleichnam",              value: [ add, 60],       type: var }
    - { name: "Tag der deutschen Einheit", value: [ "10", "03" ],   type: fix }
    - { name: "allerheiligen",             value: [ "11", "01" ],   type: fix }
    - { name: "Heiligabend",               value: [ "12", "24" ],   type: fix }
    - { name: "erster Weihnachtstag",      value: [ "12", "25" ],   type: fix }
    - { name: "zweiter Weihnachtstag",     value: [ "12", "26" ],   type: fix }
    - { name: "Silvester",                 value: [ "12", "31" ],   type: fix }
EOT;

    }
}
