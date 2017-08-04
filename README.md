# Insphptor

This repository represent an micro framework for calculate metrics in PHP projects. We objective is increase from simple way the use of metrics to measure quality your software.

## Get started

To started, run the Composer command:

```shell
composer global require leonardovilarinho/insphptor
```

After, in your project directory, run the `insphptor run` command:

```shell
insphptor run
```

## Customize

Add the `insphptor.yml` file in root from your php project, in him you can define follow options:

```yaml

# number of results displayed
ranking: 5

# format from export result
export: json

# folders and files to insphptor ignore in analyze
ignore:
  - vendor
  - tests
  - coverage
  - .phpintel

# type of file hiden from result
hide:
  - interface

# file extensions to read and analyze
extensions:
  - php
```