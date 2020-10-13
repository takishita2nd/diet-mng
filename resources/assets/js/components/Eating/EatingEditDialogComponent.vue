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
                            <td><input type="text" v-model="contents.item" /></td>
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
                    <button @click="clickEdit">編集</button>
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
            contents: {},
        };
    },
    methods: {
        dataSet: function(data) {
            this.contents = data;
        },
        clickEdit: function() {
            var self = this;
            this.param.contents = this.contents;
            axios.post('/api/eating/update', this.param).then(function(response){
                self.clear();
                self.closeModal();
                self.$emit('update');
            }).catch(function(error){
                self.error_flg = true;
                self.errors = error.response.data.errors;
            });
        },
        closeModal: function() {
            this.$parent.showEditDialogContent = false;
        },
        clear: function() {
            this.contents.date = this.date;
            this.contents.item = "";
            this.contents.timezone = 1;
            this.contents.protein = "";
            this.contents.liqid = "";
            this.contents.carbo = "";
            this.contents.calorie = "";
            this.error_flg = false;
            this.errors = [];
        }
    }
}
</script>