# EnergyAustraliaTest
Coding test at Energy Australia

## Installation
Install test.php into a root folder of your webserver.

Recommended to run from a terminal application.

## Function
The program prints out Record label model as follows;
```php
Record Label 1
   Band X
    Omega Festival
  Band Y
Record Label 2
  Band A
    Alpha Festival
    Beta Festival
## Output
It should produce a result as follows.
```php
Record Label ACR
	 Band Critter Girls
		 Festival No festival
	 Band Manish Ditch
		 Festival Trainerella
Record Label Anti Records
	 Band YOUKRANE
		 Festival Trainerella
Record Label Fourth Woman Records
	 Band Jill Black
		 Festival LOL-palooza
	 Band The Black Dashes
		 Festival Small Night In
Record Label Marner Sis. Recording
	 Band Auditones
		 Festival Twisted Tour
	 Band Green Mild Cold Capsicum
		 Festival Small Night In
	 Band Wild Antelope
		 Festival Small Night In
Record Label MEDIOCRE Music
	 Band Yanke East
		 Festival Small Night In
Record Label Monocracy Records
	 Band Adrian Venti
		 Festival Trainerella
Record Label No label
	 Band Squint-281
		 Festival Twisted Tour
	 Band Winter Primates
		 Festival LOL-palooza
Record Label Outerscope
	 Band Squint-281
		 Festival Small Night In
	 Band Summon
		 Festival Twisted Tour
Record Label Pacific Records
	 Band Frank Jupiter
		 Festival LOL-palooza
	 Band Propeller
		 Festival No festival
Record Label Still Bottom Records
	 Band Wild Antelope
		 Festival Trainerella
Record Label XS Recordings
	 Band Werewolf Weekday
		 Festival LOL-palooza
## Note
The results depends on the performance of the given APIs. 

If any malformed response was received, it prints a message read 'Malformed response returned from API end point.  try again'
