<template>
  <div class="site-branding">
    <div class="site-branding--titles">
      <h1 class="site-title">
        <a class="site-title-link" href="/">
          <span class="fezziwig">Fezziwig</span>
          <span class="media">Media</span>
          <span class="arts">Arts</span>
        </a>
      </h1>
      <h2 class="site-subtitle-1">
        <span class="drupal-wordpress">Drupal and WordPress</span>
        <span class="divider-dot">·</span>
        <span class="design-dev">Design and Development</span>
      </h2>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.site-branding {
  container-type: inline-size;
}

.site-title-link {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto auto;

  .fezziwig {
    font-size: 12.75cqi;
    grid-column: 1 / 3;
  }

  .media {
    font-size: 9.875cqi;
  }

  .arts {
    font-size: 9.875cqi;
  }

  @include breakpoint($md) {
    grid-template-columns: auto auto auto;
    grid-template-rows: auto;
    gap: 2.25cqi;
    justify-content: center;
    align-items: center;
    padding: 1.125cqi 0 0.25cqi;

    .fezziwig,
    .media,
    .arts {
      grid-column: auto;
      font-size: 5.125cqi;
    }
  }
}

.site-branding--titles {
  text-align: center;
  padding: 0;
  margin: 0;
  font-size: 1em;

  @include breakpoint($md) {
    font-size: 1.04em;
  }

  @include breakpoint($lg) {
    font-size: 1.29em;
  }

  @include breakpoint($xl) {
    font-size: 1.5em;
  }
}

.site-title {
  font-family: 'Vast Shadow', 'Arial Black', sans-serif;
  text-transform: uppercase;
  color: $color-blue--dark;
  font-size: 2.11em;
  letter-spacing: 0.115em;
  padding-bottom: 0;
  margin: 0;
  /* margin-top: -0.18em; */
  /* margin-bottom: -0.125em; */
  line-height: 1;

  @include breakpoint($md-up) {
    border-bottom: 4px double $color-orange--pale;
    padding-bottom: 0.175em;
    margin-bottom: 0.3em;
    letter-spacing: 0.138em;
  }

  @include breakpoint($lg-up) {
    letter-spacing: 0.139em;
  }

  a {
    text-decoration: none;
    color: inherit;

    &:hover {
      color: $color-blue--darkest;
    }
  }

  /* @include breakpoint($sm-down) {
    .fezziwig {
      display: block;
      font-size: 1.65em;
    }

    .media-arts {
      display: block;
      font-size: 1.27em;
      margin-top: -0.05em;
    }
  }

  @include breakpoint($xs-down) {
    .fezziwig {
      display: block;
      font-size: 0.88em;
    }

    .media-arts {
      display: block;
      font-size: 0.65em;
      margin-top: -0.01em;
    }
  } */
}

.site-subtitle-1 {
  font-family: 'Playfair Display SC', Georgia, serif;
  color: mix($color-blue--darkest, $color-orange--darkest, 60%);
  font-size: 1.1em;
  line-height: 1;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  padding: 0;
  margin: 0 auto;
  display: flex;
  width: 100%;

  span {
    flex: 1;
    white-space: nowrap;
  }

  @include breakpoint($sm-down) {
    display: none;

    .divider-dot {
      display: none;
    }

    .drupal-wordpress {
      display: block;
    }

    .design-dev {
      display: block;
    }
  }
}

.site-subtitle-2 {
  font-family: 'Playfair Display SC', Georgia, serif;
  letter-spacing: 0.115em;
  text-transform: none;
  color: $color-blue--dark;
  font-size: 0.8em;
  line-height: 1;
  padding-top: 0.5em;

  @include breakpoint($sm-down) {
    span.name {
      display: block;
      margin-bottom: 0.5em;
    }
  }
}

.site-subtitle-2 {
  display: block;

  span {
    white-space: nowrap;

    &.name {
      padding-right: 1em;
    }

    &.telephone {
      padding-left: 1em;
    }
  }
}
</style>
