<template>
    <div>
        <div id="overlay" v-show="show">
            <div id="content">
                <p v-if="error_flg == true" class="error">
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </p>
                <table class="edit">
                    <tbody>
                        <tr>
                            <td>日付</td>
                            <td>
                                <input type="date" v-model="contents.date" v-if="datehold" readonly>
                                <input type="date" v-model="contents.date" v-else>
                            </td>
                        </tr>
                        <tr>
                            <td>品名</td>
                            <td><input type="search" v-model="contents.item" autocomplete="on" list="keyword" v-on:keydown="onChangeItem" v-on:change="onChangeItem"/></td>
                            <datalist id="keyword">
                                <option v-for="keyword in keywords" v-bind:value="keyword.item" />
                            </datalist>
                        </tr>
                        <tr>
                            <td>時間帯</td>
                            <td>
                                <select name="timezone" v-model="contents.timezone">
                                    <option value="1" selected>朝</option>
                                    <option value="2">昼</option>
                                    <option value="3">夜</option>
                                    <option value="4">間食</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>タンパク質</td>
                            <td><input type="number" v-model="contents.protein" /></td>
                        </tr>
                        <tr>
                            <td>脂質</td>
                            <td><input type="number" v-model="contents.liqid" /></td>
                        </tr>
                        <tr>
                            <td>炭水化物</td>
                            <td><input type="number" v-model="contents.carbo" /></td>
                        </tr>
                        <tr>
                            <td>カロリー</td>
                            <td><input type="number" v-model="contents.calorie" /></td>
                        </tr>
                    </tbody>
                </table>
                <p id="command">
                    <button @click="clickAdd">入力</button>
                    <button @click="closeModal">閉じる</button>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['show', 'date', 'datehold'],
    data() {
        return {
            errors: [],
            error_flg: [],
            param: {},
            contents: {
                date: "",
                item: "",
                timezone: 1,
                protein: "",
                liqid: "",
                carbo: "",
                calorie: "",
            },
            keywords: [],
        };
    },
    created: function() {
        this.clear();
    },
    methods: {
        clickAdd: function() {
            var self = this;
            this.param.contents = this.contents;
            axios.post('/api/eating/add', this.param).then(function(response){
                self.closeModal();
                self.$emit('update');
            }).catch(function(error){
                self.error_flg = true;
                self.errors = error.response.data.errors;
            });
        },
        closeModal: function() {
            this.clear();
            this.$parent.showInputDialogContent = false;
        },
        clear: function() {
            this.contents.date = this.date;
            this.contents.item = "";
            this.contents.timezone = 1;
            this.contents.protein = "";
            this.contents.liqid = "";
            this.contents.carbo = "";
            this.contents.calorie = "";
            this.keywords = [];
            this.error_flg = false;
            this.errors = [];
        },
        onChangeItem: function() {
            if(this.contents.item!=""){
                var flg = this.setTemplete();
                if(flg == false) {
                    var self = this;
                    this.param.contents = this.contents;
                    axios.post('/api/eating/search', this.param).then(function(response){
                        self.keywords = [];
                        response.data.keywords.forEach(keyword => {
                            self.keywords.push(keyword);
                        });
                    }).catch(function(error){
                        self.error_flg = true;
                        self.errors = error.response.data.errors;
                    });
                }
            }else{
                this.keywords = [];
            }
        },
        setTemplete: function() {
            for (var index = 0; index < this.keywords.length; index++) {
                if(this.keywords[index].item == this.contents.item) {
                    this.contents.protein = this.keywords[index].protein;
                    this.contents.liqid = this.keywords[index].liqid;
                    this.contents.carbo = this.keywords[index].carbo;
                    this.contents.calorie = this.keywords[index].calorie;
                    return true;
                }
            }
            return false;
        }
    }
}
</script>