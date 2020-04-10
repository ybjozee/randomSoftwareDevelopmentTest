# Introduction

You are working on a utility that is responsible for secure text encoding. All encoders implement `EncodingAlgorithm` interface with a single `encode($text)` method that returns text or can throw an exception in case of failure.

# Task definition

Your task is to implement encoders to pass all tests. As you can see encoders are empty and contain only `@todo` annotation. Behavior of each encoder is described in a docblock of encode method. Additional examples are prepared for you as tests.

To complete this task you should:

* implement `OffsetEncodingAlgorithm`
* implement `SubstitutionEncodingAlgorithm`
* implement `CompositeEncodingAlgorithm`

# Hint

Think about how to prevent invalid inputs from being passed to the algorithms.
