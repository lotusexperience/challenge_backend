# Signup
**Mutation**:
```
mutation {
  signup(name: "Teste name", email: "teste@gmail.com", password: "mudar@123")
}
```

**Return**:
```
{
  "data": {
    "signup": true
  }
}
```

----------

# Auth
**Mutation**:
```
mutation {
  auth(email: "teste@gmail.com", password: "mudar@123") {
    id
    name
    email
  }
}
```

**Return**:
```
{
  "data": {
    "auth": {
      "id": 1,
      "name": "Teste name",
      "email": "teste@gmail.com"
    }
  }
}
```

----------

# FetchUsers
**Query**:
```
query {
  fetchUsers(like: "teste") {
    total
    current_page
    per_page
    last_page
    data {
      id
      name
      email
    }
  }
}
```

**Return**:
```
{
  "data": {
    "signup": true
  }
}
```
