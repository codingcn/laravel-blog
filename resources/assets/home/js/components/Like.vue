<template>
    <div>
        <span class="like_num" v-text="like_count"></span>
        <span v-on:click="like">
    <i class="fas fa-thumbs-up" v-bind:class="{'active':liked}" aria-hidden="true"></i>
    </span>
    </div>
</template>

<script>
    export default {
        props: ['comment_id', 'like_count'],
        mounted() {
            // if (this.current_user_id === this.comment_user_id) {
            //     this.liked = true
            // }else{
            //     this.liked = false
            // }
            // if (this.user_id !== '') {
            //     axios.post(site_uri + '/api/hello', {
            //         'comment_id': this.comment_id,
            //         'user_id': this.user_id
            //     }).then(response => {
            //         // console.log(response.data)
            //         this.liked = response.data.liked
            //     })
            // }
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
                    location.href = site_uri + "/sign-in"
                } else {
                    axios.post(site_uri + '/api/comment/' + this.comment_id + '/like').then(response => {
                        console.log(response.data)
                        // this.liked = response.data.liked;
                    });
                }
            }
        }
    }
</script>
