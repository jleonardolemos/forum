<script>
export default {
    props: ['attributes'],
    data() {
        return {
            editing: false,
            body: this.attributes.body
        }
    },
    methods: {
        update() {
            axios.patch('/replies/' + this.attributes.id, {
                body: this.body
            })
            this.editing = false;
            flash('updated')
        },
        destroy() {
            axios.delete(this.attributes.delete_route);
            $(this.$el).fadeOut(300, () => {
                flash('deleted')
            });
        }
    }
}
</script>
