<template>
    <div>
        <span class="like_num" v-text="count"></span>
        <span v-on:click="like">
    <i class="fas fa-thumbs-up" v-bind:class="{'active':liked}" aria-hidden="true"></i>
    </span>
    </div>
</template>

<script>
    export default {
        props: ['comment_id', 'like_count', 'is_liked'],
        mounted() {
            this.liked = this.is_liked
            this.count = this.like_count
        },
        data: function data() {
            return {
                liked: false,
                count: 0,
            };
        },
        methods: {
            like: function like() {
                if (this.user_id === '') {
                    location.href = site_uri + "/sign-in"
                } else {
                    axios.post(site_uri + '/api/comment/' + this.comment_id + '/like').then(response => {
                        let liked = response.data.data.is_like
                        this.liked = liked;
                        liked ? this.count++ : this.count--;
                    }).catch(error => {
                        if (error.response.status){
                            location.href=site_uri+"/sign-in"
                        }
                    });
                }
            }
        }
    }
</script>
