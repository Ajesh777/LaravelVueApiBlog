<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12 mt-3">
                    <h1>Articles</h1>
                    <div class="card card-body mb-3">
                        <h4>Create / Edit Articles Here: </h4>
                        <hr>
                        <form @submit.prevent="saveArt" class="mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Title"
                                v-model="article.title">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Body"
                                v-model="article.body"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Save</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#"
                            @click="fetchArt(pagination.prev_page_url)">Previous</a></li>

                            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.curr_page}} of {{ pagination.last_page}}</a></li>

                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#"
                            @click="fetchArt(pagination.next_page_url)">Next</a></li>
                        </ul>
                    </nav>
                    <div class="card card-body mb-2" v-for="article in articles" v-bind:key='article.id'>
                        <h3>{{ article.title }}</h3>
                        <p>{{ article.body }}</p>
                        <button @click="updateArt(article)" class="btn btn-primary mb-2">Edit</button>
                        <button @click="deleteArt(article.id)" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import { url } from 'Illuminate\Routing\UrlGenerator';
export default {
    
    data(){
        return{
            articles: [],
            article: {
                id: '',
                title: '',
                body: ''
            },
            article_id: '', 
            pagination: {},
            edit: false
        }
    },
    
    created(){
        this.fetchArt();
    },

    methods: {

        fetchArt(page_url) {
            let vm = this;
            //page_url = page_url || `http://www.synergysmartsol.com/lsapp/api/articles`
            fetch('http://www.synergysmartsol.com/lsapp/api/articles', {mode: 'no-cors'})
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
        },

        makePagination(meta, links) {
            let pagination = {
                curr_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }
            this.pagination = pagination;
        },

        deleteArt(id) {
            if(confirm('Are you Sure?')) {
                fetch(`api/article/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Article Deleted');
                    this.fetchArt();
                })
                .catch(err => console.log(err));
            }
        },

        saveArt() {
            if(this.edit === false) {
                //Add
                fetch(`api/article`, {
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '',
                    this.article.body = '',
                    alert('Article Added');
                    this.fetchArt();
                })
                .catch(err => console.log(err))
            } else {
                //Update
                fetch(`api/article`, {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '',
                    this.article.body = '',
                    alert('Article Updated');
                    this.fetchArt();
                })
                .catch(err => console.log(err));
            }
        },

        updateArt(article) {
            this.edit = true;
            this.article.id = article.id;
            this.article.title = article.title;
            this.article.article_id = article.id;
            this.article.body = article.body;
        }

    }
}
</script>