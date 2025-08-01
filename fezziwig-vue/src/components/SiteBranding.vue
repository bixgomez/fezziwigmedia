<template>
  <div class="site-branding">
    <div class="site-branding-titles">
      <div class="site-branding-title">
        <h1 class="site-title">
          <a class="site-title-link" href="/">
            <span class="fezziwig">Fezziwig</span>
            <span class="media">Media</span>
            <span class="arts">Arts</span>
          </a>
        </h1>
      </div>
      <div class="site-branding-title">
        <h2 class="site-subtitle">
          <span class="drupal-wordpress">Drupal and WordPress</span>
          <span class="divider-dot">·</span>
          <span class="design-dev">Design and Development</span>
        </h2>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.site-branding {
  container-type: inline-size;
}

.site-branding-titles {
  text-align: center;
  padding: 0;
  margin: 0;
  font-size: 1cqi;
  width: 100%;
}

.site-branding-title {
  padding: 2.5cqi;
  width: 100cqi;
  /* background-color: rgba(orange, 0.5); */

  &:first-of-type {
    border-bottom: 1cqi double $color-orange--paler;
  }
}

.site-title {
  font-family: 'Vast Shadow', 'Arial Black', sans-serif;
  text-transform: uppercase;
  color: $color-blue--dark;
  line-height: 1;
  margin: 0;
  padding: 0;

  @include breakpoint($md-up) {
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
}

.site-title-link {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto auto;
  container-type: inline-size;

  .fezziwig {
    font-size: 13.75cqi;
    letter-spacing: 0.725cqi;
    margin-top: -2.3cqi;
    margin-left: -0.9cqi;
    margin-bottom: -0.25cqi;
    grid-column: 1 / 3;
  }

  .media,
  .arts {
    font-size: 10cqi;
    letter-spacing: 0.9cqi;
    margin-bottom: -1.25cqi;
  }

  .media {
    margin-left: -0.5cqi;
  }

  .arts {
    margin-left: 8cqi;
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
      letter-spacing: 0.9cqi;
      margin: -1.5cqi 0;
    }
  }
}

.site-subtitle {
  font-family: 'Playfair Display SC', Georgia, serif;
  font-weight: 600;
  color: mix($color-blue--darkest, $color-orange--darkest, 40%);
  font-size: 5cqi;
  line-height: 1;
  text-transform: uppercase;
  margin: 0;
  padding: 0;
  margin: 0 auto;
  display: flex;
  width: 100%;
  flex-direction: column;

  span {
    flex: 1;
    white-space: nowrap;

    &.drupal-wordpress {
      margin-bottom: 2cqi;
      letter-spacing: 1.75cqi;

      @include breakpoint($md) {
        margin-bottom: 0;
        letter-spacing: 0.4cqi;
      }
    }

    &.design-dev {
      margin-bottom: 0.5cqi;
      letter-spacing: 1.3cqi;

      @include breakpoint($md) {
        margin-bottom: 0;
        letter-spacing: 0.4cqi;
      }
    }
  }

  @include breakpoint($md) {
    flex-direction: row;
    font-size: 2.75cqi;
  }

  .divider-dot {
    display: none;

    @include breakpoint($md) {
      display: block;
    }
  }
}
</style>
