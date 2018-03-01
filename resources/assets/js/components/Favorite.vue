<template>
    <button :class="classes" @click="toggle()">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
export default {
    props: ['reply'],
    data(){
        return {
            count: this.reply.favorites.length,
            active: this.reply.is_favorite
        }
    },
    computed: {
        classes() {
            return ['btn', this.active ? 'btn-primary' : 'btn-default'];
        }
    },
    methods: {
        toggle() {
            if (this.active) {
                this.delete();
            } else {
                this.create();
            }
        },
        create() {
            axios.post(this.reply.favorite_route);
            this.active = true;
            this.count++;
        },
        delete() {
            axios.delete(this.reply.unfavorite_route);
            this.active = false;
            this.count--;
        }
    }
}
</script>

