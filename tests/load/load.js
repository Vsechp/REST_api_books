import http from 'k6/http';
import { check } from 'k6';

const baseURL = 'http://127.0.0.1:8000';
const registerEndpoint = '/register';
const loginEndpoint = '/login';
const booksEndpoint = '/books';

let testUser = {
    email: `user${Math.random().toString(36).substring(7)}@test.com`,
    password: '11111111',
};

export default function () {
    let res;

    // /register
    res = http.post(`${baseURL}${registerEndpoint}`, JSON.stringify(testUser), { headers: { 'Content-Type': 'application/json' } });
    check(res, {
        'register status was 200': (r) => r.status === 200,
        'response body contains "User registered successfully"': (r) => r.body.indexOf('User registered successfully') !== -1,
    });

    // Same user again
    res = http.post(`${baseURL}${registerEndpoint}`, JSON.stringify(testUser), { headers: { 'Content-Type': 'application/json' } });
    check(res, {
        'register status was 400': (r) => r.status === 400,
        'response body contains "User with this email already exists"': (r) => r.body.indexOf('User with this email already exists') !== -1,
    });

    let authToken;

// /login
    res = http.post(`${baseURL}${loginEndpoint}`, JSON.stringify(testUser), { headers: { 'Content-Type': 'application/json' } });
    check(res, {
        'login status was 200': (r) => r.status === 200,
        'response body contains token': (r) => {
            const body = r.json();
            authToken = body.token;
            return true;
        },
    });

// /books
    res = http.get(`${baseURL}${booksEndpoint}`, { headers: { 'Authorization': `Bearer ${authToken}` } });
    console.log(res.body);
    check(res, {
        'books status was 200': (r) => r.status === 200,
        'response body is an JSON': (r) => {
            if (r.headers['Content-Type'].includes('application/json')) {
                let body;
                try {
                    body = JSON.parse(r.body);
                } catch (e) {
                    console.error('Response is not JSON');
                    return false;
                }
                return Array.isArray(body);
            } else {
                console.error('Response is not JSON');
                return false;
            }
        },
    });
};
