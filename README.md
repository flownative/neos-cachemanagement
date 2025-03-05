[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/flownative/neos-cachemanagement.svg)](https://packagist.org/packages/flownative/neos-cachemanagement)
[![Maintenance level: Acquaintance](https://img.shields.io/badge/maintenance-%E2%99%A1-ff69b4.svg)](https://www.flownative.com/en/products/open-source.html)

# Neos Cache Management Backend Module

![Screenshot of the Cache Management Module](Documentation/BackendScreenshot.png)

This [Neos](https://www.neos.io) backend module provides cache management functions to Neos administrators who don't have access to a Flow shell. In this early version, the backend module simply allows for flushing different caches (Neos_Fusion_Content, Flow_Mvc_Routing_Route and Flow_Mvc_Routing_Resolve by default).

# Installation

Simply install this package via Composer. The package key is `flownative/neos-cachemanagement`.

## Configuration

### Add labels to a cache configuration

To add a label and a description to a cache configuration, you can use the following configuration in your `Settings.yaml`:

```yaml
Flownative:
  Neos:
    CacheManagement:
      caches:
        Neos_Fusion_Content:
          label: 'Neos Content'
          description: 'Caches the rendering of Neos content elements.'
```

### Hide Cache-Hint

To hide the cache hint set the following configuration in your `Settings.yaml`:

```yaml
Flownative:
  Neos:
    CacheManagement:
      ui:
        showCacheHint: false
```
