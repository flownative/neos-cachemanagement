[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
![Packagist][packagist]
[packagist]: https://img.shields.io/packagist/v/flownative/neos-cachemanagement.svg

# Neos Cache Management Backend Module

[![Screenshot of the Cache Management Module](Documentation/BackendScreenshot.png)]

This [Neos](https://www.neos.io) backend module provides cache management functions to Neos administrators. In this
early version, the backend module simply allows for flushing the content cache (TYPO3_TypoScript_Content).

Note that in general it is not necessary to flush content caches manually. This is rather a sign of a mis-configured
website. Before making it a habit to flush caches, please read and implement the advises mentioned in the respective
section of the [Neos Manual](http://neos.readthedocs.org/en/stable/CreatingASite/ContentCache.html).
