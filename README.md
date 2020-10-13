# Redaxo stats Addon

A small addon to gather statistics about visitors for a redaxo website. It does not use
Cookies or Client-side scripts but instead only logs page renders. Based on timestamps
and available navigation options, user paths can be correlated.

The only data gathered is:
- the timestamp of the visit
- the requested page
- if present, a referrer
