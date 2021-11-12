# code_generation

Website for generating lottery codes with a form.
The Form contains three fields:
- Available Chars (String with all chars the code consists of)
- Codes length
- Number of codes to generate

## Requirements
- `docker-compose` (version 1.21.0)
- `composer` (version 2.1.12)

## Install & Usage 
```
git clone https://github.com/rbrtwlz/code_generation
cd code_generation
composer install
docker-compose -f docker-compose up -d
```
Then you can go to http://localhost:80

## Todo
- Form validation
- Exception handling
- using symfony POST routing instead of `$_POST`
- Testing
- ?