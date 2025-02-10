import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    userData: {
      name: "",
      cpf: "",
      gender: "",
      phone: "",
      password: "",
      role: "",
    },
    quiaData: {
      valor: "",
      pais: "",
      estado: "",
      cidade: "",
    },
    turistaData: {
      pais: "",
      estado: "",
      cidade: "",
    },
    combinedData: {},
  }),
  actions: {
    setUserData(data: Partial<typeof this.userData>) {
      this.userData = { ...this.userData, ...data };
    },
    setQuiaData(data: Partial<typeof this.quiaData>) {
      this.quiaData = { ...this.quiaData, ...data };
    },
    setTuristaData(data: Partial<typeof this.turistaData>) {
      this.turistaData = { ...this.turistaData, ...data };
    },
    combineWithQuiaData() {
      this.combinedData = { ...this.userData, ...this.quiaData };
    },
    combineWithTuristaData() {
      this.combinedData = { ...this.userData, ...this.turistaData };
    },
  },
  getters: {
    getUserDataPegar: (state) => state.userData,
    getQuiaData: (state) => state.quiaData,
    getTuristaData: (state) => state.turistaData,
    getCombinedData: (state) => state.combinedData,
  }
});
