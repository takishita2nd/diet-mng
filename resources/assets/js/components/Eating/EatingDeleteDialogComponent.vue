<template>
    <div>
        <div id="overlay" v-show="show">
            <div id="content">
                <p v-if="error_flg == true" class="error">
                    <ui>
                        <li v-for="error in errors">{{ error }}</li>
                    </ui>
                </p>
                <table class="edit">
                    <tbody>
                        <tr>
                            <td>日付</td>
                            <td>{{contents.date}}</td>
                        </tr>
                        <tr>
                            <td>品名</td>
                            <td>{{contents.item}}</td>
                        </tr>
                        <tr>
                            <td>時間帯</td>
                            <td>{{contents.time}}</td>
                        </tr>
                        <tr>
                            <td>タンパク質</td>
                            <td>{{contents.protein}}</td>
                        </tr>
                        <tr>
                            <td>脂質</td>
                            <td>{{contents.liqid}}</td>
                        </tr>
                        <tr>
                            <td>炭水化物</td>
                            <td>{{contents.carbo}}</td>
                        </tr>
                        <tr>
                            <td>カロリー</td>
                            <td>{{contents.calorie}}</td>
                        </tr>
                    </tbody>
                </table>
                <p id="command">
                    <button @click="clickDelete">削除</button>
                    <button @click="closeModal">閉じる</button>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['show'],
    data() {
        return {
            errors: [],
            error_flg: [],
            param: {},
            contents: {},
        };
    },
    created: function() {
    },
    methods: {
        dataSet: function(data) {
            this.contents = data;
            switch(this.contents.timezone) {
                case 1:
                    this.contents.time = "朝";
                    break;
                case 2:
                    this.contents.time = "昼";
                    break;
                case 3:
                    this.contents.time = "夜";
                    break;
                case 4:
                    this.contents.time = "間食";
                    break;
            }
        },
        clickDelete: function() {
            var self = this;
            this.param.contents = this.contents;
            axios.post('/api/eating/delete', this.param).then(function(response){
                self.closeModal();
                self.$emit('update');
            }).catch(function(error){
                self.error_flg = true;
                self.errors = error.response.data.errors;
            });
        },
        closeModal: function() {
            this.$parent.showDeleteDialogContent = false;
        },
    }
}
</script>
