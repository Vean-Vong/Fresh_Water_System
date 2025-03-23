<template>
    <div class="container_setting">
        <div class="col-sm-3 drop-zone" @click="goToUsers">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                <i class="fas fa-plus"></i> {{ $t("add") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-users"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <span class="text-white opacity-8">{{
                            $t("users")
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                <i class="fas fa-plus"></i> {{ $t("add") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-user-lock"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <span class="text-white opacity-8">{{
                            $t("permission")
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 drop-zone">
            <div class="card text-white draggable">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title text-white opacity-9">
                                <i class="fas fa-plus"></i> {{ $t("add") }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i
                                    class="fas fa-briefcase"
                                    style="font-size: 40px"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <span class="text-white opacity-8">{{
                            $t("role")
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.container_setting {
    display: flex;
    gap: 20px;
}
</style>

<script>
export default {
    data() {
        return {};
    },
    methods: {
        goToUsers() {
            this.$router.push("/users");
        },
    },
};
</script>
