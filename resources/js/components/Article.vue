<template>
    <div>

        <h2 class="text-center">Article</h2>
        
            <div class="card mb-5">
                <div class="card-header">Add New Article</div>

                <div class="card-body">
                    <form @submit.prevent="addArticle">
                        <strong>Title:</strong>
                        <input type="text" class="form-control" v-model="article.title">
                        <strong>Description:</strong>
                        <textarea class="form-control" v-model="article.body"></textarea>

                        <button class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li  class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]" ><a class="page-link" href="#" v-on:click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                
                <li class="page-item disabled"><a class="page-link" href="#">Page {{pagination.crount_page}} of {{pagination.last_page}}</a></li>
                
                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]" ><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>


        <div class=" card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3> <span class=" badge badge-success">{{article.id}}</span> {{article.title}} </h3>
            <p> {{article.body}} </p>
            <div class="float-right">
                <button class="btn" @click="deleteArticle(article.id)"><span class="badge badge-danger">Delete</span></button>
                <button class="btn" @click="editArticle(article)"><span class="badge badge-info">Edit</span></button>
            </div>
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
            fetchArticles(page_url){
                let vm = this;
                page_url = page_url || 'api/articles';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        // console.log(res.data);
                        this.articles = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    crount_page: meta.current_page,
                    last_page: meta.last_page,
                    prev_page_url: links.prev,
                    next_page_url: links.next,
                };
                // console.log(pagination);
                this.pagination = pagination;
            },
            deleteArticle(id){
                if (confirm('Are you sure?')) {
                    fetch(`api/articles/${id}`,{
                        method:'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Article Removed');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            addArticle(){
                if (this.edit === false) {
                    
                    fetch('api/articles',{
                        method: 'post',
                        body:JSON.stringify(this.article),
                        headers:{
                            'content-type': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        alert('New Article Add Successfully');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err))
                }else{
                    let update_url = `api/articles/${this.article_id}`;
                    fetch(update_url,{
                        method: 'put',
                        body:JSON.stringify(this.article),
                        headers:{
                            'content-type': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        this.article_id = '';
                        alert('Article Successfully Updated');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err))
                }
            },
            editArticle(article){
                this.edit = true;
                this.article.id = article.id;
                this.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>