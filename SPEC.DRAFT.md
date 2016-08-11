_This document should NOT be considered authoritative or informative in any meaningful way yet. It is an early draft outlining some of the decisions already made and some of the changes that ought to be implented. But that's it so far. It is included here for safe-keeping and as an "FYI"._

```
+ references

  - https://en.wikipedia.org/wiki/Standard_Generalized_Markup_Language

  - http://docbook.org/
  - http://www.markdown2docbook.com/

  - http://perldoc.perl.org/perlpod.html
  - https://metacpan.org/pod/Acme::Test::Weather
  - https://metacpan.org/source/ASCOPE/Acme-Test-Weather-0.2/lib/Acme/Test/Weather.pm (click the "show lines of POD" link)
  
  - https://www.flickr.com/services/api/
  - https://www.flickr.com/services/api/misc.overview.html

  - https://collection.cooperhewitt.org/api/methods/
  - https://collection.cooperhewitt.org/api/methods/api.spec.methods
  - https://collection.cooperhewitt.org/api/methods/api.spec.methods/explore/
  - https://github.com/whosonfirst/flamework-api/blob/master/www/include/config_api_methods.php
  
# things not discussed

  - "blessed" API keys/methods
  - common API parameters (e.g. pagination)
  - common API errors
  
+ methods

  - method
  
    + parameters
      - parameter
      	- name		(string)
      	- description	(string)
      	- required	(bool)
      	- documented	(bool)
      	- paginated	(bool)
      	- enabled	(bool)
      	~ defaults	(singleton? list?)
      
    + errors
      - error
        - code		(int)
      	- name		(string)
      	- description	(string)

    + notes
      - note		(mixed content)

    + "requirements"
      - enabled			(bool)
      - documented		(bool)
      - requires_method		(string; HTTP method)
      - requires_auth		(bool)
      - requires_crumb		(bool)
      - requires_blessing	(bool)      
      - requires_perms		(int; read, write, etc.)
      - requires_host	        (list)
      - requires_key		(list)
      - requires_key_type	(list; user, site, infrastructure)
      
+ formats

  - format

    - name		(string)
    - description	(string)
    - example		(mixed content)
    
+ glossary

  - term		(string)
  - definition		(string)
  - see also		(mixed content? list?)

```
