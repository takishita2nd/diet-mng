<template>
    <div>
        <div class="dashboard">
            <div class="chart">
                <canvas id="weight"></canvas>
            </div>
            <div class="command">
                <ul>
                    <li><a @click="onClickInput">クイック入力</a></li>
                    <li><a href="">詳細</a></li>
                </ul>
            </div>
        </div>
        <div id="overlay" v-show="showDialogContent">
            <div id="content">
                <table class="edit">
                    <tbody>
                        <tr>
                            <td>体重</td>
                            <td><input type="number" /></td>
                        </tr>
                        <tr>
                            <td>体脂肪</td>
                            <td><input type="number" /></td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td><input type="number" /></td>
                        </tr>
                    </tbody>
                </table>
                <p id="command">
                    <button @click="closeModal">入力</button>
                    <button @click="closeModal">閉じる</button>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showDialogContent: false,
        };
    },
    created: function() {

    },
    methods: {
        onClickInput: function() {
            this.showDialogContent = true;
        },
        closeModal: function() {
            this.showDialogContent = false;
        }
    }
}
</script>