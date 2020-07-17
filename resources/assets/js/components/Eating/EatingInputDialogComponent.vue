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
                            <td>品名</td>
                            <td><input type="text" v-model="contents.item" /></td>
                        </tr>
                        <tr>
                            <td>タンパク質</td>
                            <td><input type="number" v-model="contents.protein" /></td>
                        </tr>
                        <tr>
                            <td>脂質</td>
                            <td><input type="number" v-model="contents.riqid" /></td>
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
    props: ['show'],
    data() {
        return {
            errors: [],
            error_flg: [],
            param: {},
            contents: {
                item: "",
                protein: "",
                riqid: "",
                carbo: "",
                calorie: "",
            },
        };
    },
    created: function() {
    },
    methods: {
        clickAdd: function() {
            // var self = this;
            // this.param.contents = this.contents;
            // axios.post('api/weight/add', this.param).then(function(response){
            //     self.clear();
            //     self.closeModal();
            //     self.$emit('update');
            // }).catch(function(error){
            //     self.error_flg = true;
            //     self.errors = error.response.data.errors;
            // });
        },
        closeModal: function() {
            this.$parent.showInputDialogContent = false;
        },
        clear: function() {
            this.contents.item = "";
            this.contents.protein = "";
            this.contents.riqid = "";
            this.contents.carbo = "";
            this.contents.calorie = "";
            this.error_flg = false;
            this.errors = [];
        }
    }
}
</script>