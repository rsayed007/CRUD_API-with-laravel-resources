<template>
    <div>
        <h2 class="text-center">Article</h2>
        <div class=" card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3> {{article.title}} </h3>
            <p> {{article.body}} </p>
        </div>
            <br>    
    </div>
</template>

<script>
    export default {
        data(){
            return{
                articles:[],
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination:{},
                edit: false,
            }
        },
        created(){
            this.fetchArticles();
        },
        methods: {
            fetchArticles(){
                fetch('api/articles')
                    .then(res => res.json())
                    .then(res => {
                        // console.log(res.data);
                        this.articles = res.data;
                    })
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>