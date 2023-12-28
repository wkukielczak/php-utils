Changelog
=========

1.0.3
-----

- Added `ToArrayTrait` trait which enables "toArray" method for every object. 
The method gets all the object's properties and put their non-null values into an array.
- Private method's name typo fixed in GeoCoordinates class
- Minimal PHP version bumped to 8.0 in `composer.json`
- Utils docs added

1.0.2
-----

- Some PHPDocs were added/updated so all the methods has at least basic descriptions
- Minimal required PHP version lowered down to 7.0 to preserve compatibility with more projects 

1.0.1
-----

Project dependencies were changed so the lib don't require PHP extensions required by PHPUnit anymore.

1.0.0
-----

- Initial commit. Available functionality:
  - Safely get a value from an array
  - Cryptographic number generator
  - Cryptographic string token generator
  - Doctrine: add haversine formulae to a DQL query, so you can query for the nearest geographic spot
  - Count geographic distance between two objects
  - Check if the string can be safely converted to a float number
