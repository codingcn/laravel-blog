<template>
  <div>
    <span class="like_num" v-text="like_count"></span>
    <span v-on:click="like">
    <i class="fa fa-thumbs-o-up" v-bind:class="{'active':liked}" aria-hidden="true"></i>
    </span>
  </div>
</template>

<script>
  export default {
    props: ['comment_id', 'user_id', 'like_count'],
    mounted() {
      if (this.user_id !== '') {
        axios.post(site_uri + '/api/hello', {
          'comment_id': this.comment_id,
          'user_id': this.user_id
        }).then(response => {
          this.liked = response.data.liked
        })
      }
    },
    data: function data() {
      return {
        liked: false
      };
    },

    compute: {
//      like_count() {
//        return this.liked ? '1' : '0'
//      }
    },
    methods: {
      like: function like() {
        if (this.user_id === '') {
          alert('请先登陆！');
        } else {
          axios.post(site_uri + '/api/hello', {
            'comment_id': this.comment_id,
            'user_id': this.user_id
          }).then(response => {
            this.liked = response.data.liked;
          });
        }
      }
    }
  }
</script>
