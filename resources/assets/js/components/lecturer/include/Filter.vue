<template>
    <v-container fluid grid-list-xl v-if="isLoaded">
        <v-layout wrap align-center>
            <v-flex md4 mt-5 d-flex>
                <v-select 
                    :items="filter.list_semester"
                    v-model="filter.semester"
                    label="Pilih semester"
                    item-text="tahun"
                    item-value="semester"
                    @change="selectKelas()"
                    solo
                >
                    <template slot="selection" slot-scope="data">
                        {{ data.item.semester }}
                    </template>
                    <template slot="item" slot-scope="data">
                        {{ data.item.semester }}
                    </template>
                </v-select>
            </v-flex>
            <v-flex md4 mt-5 d-flex>
                <v-select 
                    :items="filter.list_kelas"
                    v-model="filter.kelas"
                    label="Pilih kelas"
                    item-text="kode"
                    item-value="nomor"
                    @change="selectMatakuliah()"
                    solo
                >
                    <template slot="selection" slot-scope="data">
                        {{ data.item.kode }}
                    </template>
                    <template slot="item" slot-scope="data">
                        {{ data.item.kode }}
                    </template>
                </v-select>
            </v-flex>
            <v-flex md4 mt-5 d-flex>
                <v-select 
                    :items="filter.list_matakuliah"
                    v-model="filter.matakuliah"
                    label="Pilih matakuliah"
                    item-text="matakuliah"
                    item-value="nomor"
                    @change="selectData()"
                    solo
                >
                    <template slot="selection" slot-scope="data">
                        {{ data.item.matakuliah }}
                    </template>
                    <template slot="item" slot-scope="data">
                        {{ data.item.matakuliah }}
                    </template>
                </v-select>
            </v-flex>
        </v-layout>
    </v-container>
</template>
