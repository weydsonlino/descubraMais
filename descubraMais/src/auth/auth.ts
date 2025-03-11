import axios from 'axios'
class useAuth{
    private static get token() {
      return localStorage.getItem('token')
    }
    private static api = axios.create({
    baseURL: 'http://localhost:8000', // Defina a URL base do seu backend
    headers: {
      'Content-Type': 'application/json',
      Authorization: useAuth.token ? `Bearer ${useAuth.token}` : '',
    },

    });
    public static async axiosWithAuth(
      endpoint: string,
      options: {
        method?: string
        data?: any
        headers?: Record<string, string>
      } = {},
    ) {
      try {
        // Adicionar o token atualizado nos headers antes da requisição
        const authHeaders = useAuth.token
          ? { Authorization: `Bearer ${useAuth.token}` }
          : {}

        const response = await this.api({
          url: endpoint,
          method: options.method || 'GET',
          data: options.data || null,
          headers: { ...authHeaders, ...options.headers },
        })

        return response.data
      } catch (error) {
        throw error.response ? error.response.data.message : 'Erro na requisição'
      }
    }
    public static async login(form){
      try {
        const response = await axios.post('http://localhost:8000/login', form);
        const { token } = response.data;
        localStorage.setItem('token', token);
        this.api.defaults.headers.Authorization = `Bearer ${token}`;
        return response.data;
      } catch (error) {
        throw error.response ? error.response.data.message : error;
      }
    }
    public static async logout(){
      localStorage.removeItem('token');
      delete api.defaults.headers.Authorization;
    }

}

export default useAuth
