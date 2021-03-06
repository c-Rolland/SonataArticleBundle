# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [1.2.1](https://github.com/sonata-project/SonataArticleBundle/compare/1.2.0...1.2.1) - 2019-10-14
### Fixed
- Syntax error in template

## [1.2.0](https://github.com/sonata-project/SonataArticleBundle/compare/1.1.0...1.2.0) - 2019-05-28

### Added
- Add `|trans()` in the follow twig files: `edit_collection_fragment.html.twig`
  and `form.html.twig` to translate the fragment name.
- Add Hungarian translations

### Changed
- Changed `ArticleInterface`, `FragmentInterface` and
`ArticleFragmentInterface` to allow null return types.

### Fixed
- Fix deprecation for symfony/config 4.2+

## [1.1.0](https://github.com/sonata-project/SonataArticleBundle/compare/1.0.0...1.1.0) - 2018-12-11
### Added
- Added `Article::isValidated()` method

### Fixed
- Fixed `Article::getValidatedAt()` to be able to return null

### Changed
- In `AbstractArticle`, `getValidatedAt(): \DateTimeInterface` becomes
  `getValidatedAt(): ?\DateTimeInterface`, this is technically a BC-break
