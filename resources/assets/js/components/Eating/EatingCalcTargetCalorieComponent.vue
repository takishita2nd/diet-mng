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
                            <td>身長</td>
                            <td><input type="number" v-model="inputParameter.height" /></td>
                        </tr>
                        <tr>
                            <td>体重</td>
                            <td><input type="number" v-model="inputParameter.weight" /></td>
                        </tr>
                        <tr>
                            <td>年齢</td>
                            <td><input type="number" v-model="inputParameter.age" /></td>
                        </tr>
                        <tr>
                            <td>アクティブ度</td>
                            <td>
                                <select name="active" v-model="inputParameter.active">
                                    <option value="1" selected>低</option>
                                    <option value="2">中</option>
                                    <option value="3">高</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>目的</td>
                            <td>
                                <select name="target" v-model="inputParameter.target">
                                    <option value="1" selected>維持</option>
                                    <option value="2">減量</option>
                                    <option value="3">増量</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p />
                <table class="edit">
                    <tbody>
                        <tr>
                            <td>目標カロリー</td>
                            <td>{{calorie}} cal</td>
                        </tr>
                        <tr>
                            <td>タンパク質</td>
                            <td>{{protein}} g</td>
                        </tr>
                        <tr>
                            <td>脂質</td>
                            <td>{{liqid}} g</td>
                        </tr>
                        <tr>
                            <td>炭水化物</td>
                            <td>{{carbo}} g</td>
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
            inputParameter: {
                height: 0,
                weight: 0,
                age: 0,
                active: 1,
                target: 1,
            },
            contents: {
                calorie: 0,
                protein: 0,
                liqid: 0,
                carbo: 0,
            },
        };
    },
    created: function() {
        this.clear();
    },
    computed: {
        calorie: function() {
            var cal = 10 * this.inputParameter.weight + 6.25 * this.inputParameter.height - 5 * this.inputParameter.age + 5;
            var k = 1;
            // アクティブ度の計算
            switch(this.inputParameter.active){
                case "1": k = 1.2; break;
                case "2": k = 1.55; break;
                case "3": k = 1.725; break;
            }
            cal = cal * k;
            // 目標の計算
            switch(this.inputParameter.target){
                case "1": k = 1; break;
                case "2": k = 0.8; break;
                case "3": k = 1.2; break;
            }
            this.contents.calorie = Math.ceil(cal * k);
            return this.contents.calorie;
        },
        protein: function() {
            this.contents.protein = this.inputParameter.weight * 2;
            return this.contents.protein;
        },
        liqid: function() {
            this.contents.liqid = Math.ceil(this.contents.calorie * 0.25 / 9);
            return this.contents.liqid;
        },
        carbo: function() {
            this.contents.carbo = Math.ceil((this.contents.calorie - this.contents.protein * 4 - this.contents.liqid * 9) / 4);
            return this.contents.carbo;
        },
    },
    methods: {
        clickAdd: function() {
            var self = this;
            this.param.contents = this.contents;
            axios.post('/api/eating/settarget', this.param).then(function(response){
                self.closeModal();
                self.$emit('update');
            }).catch(function(error){
                self.error_flg = true;
                self.errors = error.response.data.errors;
            });
        },
        closeModal: function() {
            this.$parent.showCalcCalorieContent = false;
        },
        clear: function() {
            this.inputParameter.height = 0;
            this.inputParameter.weight = 0;
            this.inputParameter.age = 0;
            this.inputParameter.active = "1";
            this.inputParameter.target = "1";
            this.contents.calorie = 0;
            this.contents.protein = 0;
            this.contents.liqid = 0;
            this.contents.carbo = 0;
            this.error_flg = false;
            this.errors = [];
        }
    }
}
</script>