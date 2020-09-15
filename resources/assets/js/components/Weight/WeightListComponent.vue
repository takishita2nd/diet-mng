<template>
    <div>
        <div>
            <p id="navi">> <a href="/home">HOME</a></p>
            <p id="inputbutton">
                <button @click="onClickInput">データ入力</button>
            </p>
            <div id="pagenate">
                <ul>
                    <li>
                        <a href="#" v-if="prevShow" @click="prevPage()">&lt;</a>
                        <b v-else>&lt;</b>
                    </li>
                    <li v-for="page in pagenates">
                        <a href="#" v-if="currentPage != page" @click="changePage(page)">{{ page }}</a>
                        <b v-else>{{ page }}</b>
                    </li>
                    <li>
                        <a href="#" v-if="nextShow" @click="nextPage()">&gt;</a>
                        <b v-else>&gt;</b>
                    </li>
                </ul>
            </div>
            <table class="weightlist">
                <tbody>
                    <tr>
                        <th class="date">日時</th>
                        <th class="weight">体重(kg)</th>
                        <th class="fat_rate">体脂肪(%)</th>
                        <th class="bmi">BMI</th>
                        <th class="edit"></th>
                        <th class="delele"></th>
                    </tr>
                    <tr v-for="data in datalists">
                        <td class="date">{{ data.date}}</td>
                        <td class="weight">{{ data.weight}}</td>
                        <td class="fat_rate">{{ data.fat_rate}}</td>
                        <td class="bmi">{{ data.bmi}}</td>
                        <td class="edit"><a @click="onClickEdit(data.id)">Edit</a></td>
                        <td class="delele"><a @click="onClickDelete(data.id)">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <weight-input-dialog-component :show="showInputDialogContent" @update="invokeUpdateList"></weight-input-dialog-component>
            <weight-edit-dialog-component ref="editDialog" :show="showEditDialogContent" @update="invokeUpdateList"></weight-edit-dialog-component>
            <weight-delete-dialog-component ref="deleteDialog" :show="showDeleteDialogContent" @update="invokeUpdateList"></weight-delete-dialog-component>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showInputDialogContent: false,
            showEditDialogContent: false,
            showDeleteDialogContent: false,
            datalists: [],
            pagenates: [],
            currentPage: 1,
            maxPage: 1,
            param: {},
            contents: {
                page: "",
            },
        };
    },
    computed: {
        prevShow: function() {
            return this.currentPage != 1;
        },
        nextShow: function() {
            return this.currentPage != this.maxPage;
        },
    },
    created: function() {
        this.updateList();
        this.createPagenate();
    },
    methods: {
        createPagenate: function() {
            var self = this;
            this.pagenates = [];
            axios.post('/api/weight/total').then(function(response){
                var total = response.data.total;
                self.maxPage = Math.floor(total / 10) + 1;
                for(var i = 1; i <= self.maxPage; i++) {
                    self.pagenates.push(i);
                }
            }).catch(function(error){
            });
        },
        changePage: function(page) {
            this.currentPage = page;
            this.updateList();
        },
        nextPage: function() {
            this.currentPage += 1;
            if(this.currentPage > this.maxPage) {
                this.currentPage = this.maxPage;
            }
            this.updateList();
        },
        prevPage: function() {
            this.currentPage -= 1;
            if(this.currentPage <= 0) {
                this.currentPage = 0;
            }
            this.updateList();
        },
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        onClickEdit: function(id) {
            var editData = {};
            this.datalists.forEach(element => {
                if(element.id == id){
                    editData.id = id;
                    editData.weight = element.weight;
                    editData.fat_rate = element.fat_rate;
                    editData.bmi = element.bmi;
                    return true;
                }
            });
            this.$refs.editDialog.dataSet(editData);
            this.showEditDialogContent = true;
        },
        onClickDelete: function(id) {
            var editData = {};
            this.datalists.forEach(element => {
                if(element.id == id){
                    editData.id = id;
                    editData.date = element.date;
                    editData.weight = element.weight;
                    editData.fat_rate = element.fat_rate;
                    editData.bmi = element.bmi;
                    return true;
                }
            });
            this.$refs.deleteDialog.dataSet(editData);
            this.showDeleteDialogContent = true;
        },
        invokeUpdateList: function() {
            this.updateList();
        },
        updateList: function() {
            this.datalists = [];
            this.contents.page = this.currentPage;
            this.param.contents = this.contents;
            var self = this;
            axios.post('/api/weight/list', this.param).then(function(response){
                response.data.dataLists.forEach(element => {
                    self.datalists.push({
                        id: element.id,
                        date: element.datetime,
                        weight: element.weight,
                        fat_rate: element.fat_rate,
                        bmi: element.bmi
                    })
                });
            }).catch(function(error){
            });
        }
    }
}
</script>