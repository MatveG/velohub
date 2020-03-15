<template>
  <article class="media">
    <div class="media-content">
      <div class="content">
        <slot/>
      </div>
      <nav class="level is-mobile">
        <div class="level-left">
          <div class="level-item">
            <span v-if="icon" class="tag is-small" :class="status">
              <b-icon :icon="icon" size="is-small"/>
            </span>
          </div>
          <div v-if="timestamp" class="level-item">
            <small>{{ timeAgo }}</small>
          </div>
        </div>
      </nav>
    </div>
  </article>
</template>

<script>
import moment from 'moment'

export default {
  name: 'AsideUpdatesItem',
  props: {
    icon: {
      type: String,
      default: null
    },
    status: {
      type: String,
      default: 'is-info'
    },
    timestamp: {
      type: Number,
      default: null
    }
  },
  computed: {
    timeAgo () {
      return moment.unix(this.timestamp).from(moment())
    }
  }
}
</script>
