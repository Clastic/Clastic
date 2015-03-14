Contributing
============

Clastic is an open source, community driven project.

If you'd like to contribute, please read this guide.

How to report a bug
-------------------

Read the following before reporting a bug:

 - Update to the newest version
 - Check if someone has already reported the same bug

When reporting a bug on GitHub, make sure you include the following information:

 - Detailed description of the problem
 - How to reproduce the issue (step-by-step)
 - What you have already tried

Coding Guidelines
-----------------

To ensure a consistent code base, you should make sure the code follows
the [Coding Standards](http://symfony.com/doc/current/contributing/code/standards.html)
which we borrowed from Symfony.
Make sure to check out [php-cs-fixer](https://github.com/fabpot/PHP-CS-Fixer) as this will help you a lot.

Pull Requests
-------------

Please follow the following rules when submitting a pull request. These rules make for a uniform codebase.
When not all rules are met, your work might not get merged.

 - All changed files follow the coding guidelines
 - New features have unit tests
 - Bugfixes have a unit test proving the change.
 - The branch is rebased before submitting the Pull Request

When your changes are accepted they might need to be squashed into one commit.

> __Commit messages__
>
> A good commit message is composed of a summary (the first line), optionally followed by a blank line and
> a more detailed description.
>
> The summary should start with the Component you are working on in square
> brackets ([Blog], [Backoffice], ...). Use a verb (fixed ..., added ..., ...) to start the summary and
> don't add a period at the end.
