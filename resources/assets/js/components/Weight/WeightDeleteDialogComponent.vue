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
                            <td>日時</td>
                            <td>{{contents.date}}</td>
                        </tr>
                        <tr>
                            <td>体重</td>
                            <td>{{contents.weight}}</td>
                        </tr>
                        <tr>
                            <td>体脂肪</td>
                            <td>{{contents.fat_rate}}</td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td>{{contents.bmi}}</td>
                        </tr>
                    </tbody>
                </table>
                <p id="command">
                    <button @click="clickDelete">OK</button>
                    <button @click="closeModal">キャンセル</button>
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
                date: "",
                weight: "",
                fat_rate: "",
                bmi: "",
            },
        };
    },
    created: function() {
    },
    methods: {
        dataSet: function(data) {
            this.contents = data;
        },
        clickDelete: function() {
            var self = this;
            this.param.contents = this.contents;
            axios.post('api/weight/delete', this.param).then(function(response){
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