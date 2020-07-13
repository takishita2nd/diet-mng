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
                            <td>体重</td>
                            <td><input type="number" v-model="contents.weight" /></td>
                        </tr>
                        <tr>
                            <td>体脂肪</td>
                            <td><input type="number" v-model="contents.fat_rate" /></td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td><input type="number" v-model="contents.bmi" /></td>
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
                weight: "",
                fat_rate: "",
                bmi: "",
            },
        };
    },
    created: function() {
    },
    methods: {
        clickAdd: function() {
            var self = this;
            this.param.contents = this.contents;
            axios.post('api/weight/add', this.param).then(function(response){
                self.clear();
                self.closeModal();
                self.$emit('update');
            }).catch(function(error){
                self.error_flg = true;
                self.errors = error.response.data.errors;
            });
        },
        closeModal: function() {
            this.$parent.showInputDialogContent = false;
        },
        clear: function() {
            this.contents.weight = "";
            this.contents.fat_rate = "";
            this.contents.bmi = "";
            this.error_flg = false;
            this.errors = [];
        }
    }
}
</script>