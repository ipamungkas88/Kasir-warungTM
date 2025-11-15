# 🔌 API Documentation - Warung TM

Dokumentasi API lengkap untuk integrasi dan pengembangan sistem kasir Warung TM.

## 📋 Table of Contents

-   [Authentication](#authentication)
-   [Base Information](#base-information)
-   [User Management](#user-management)
-   [Menu Management](#menu-management)
-   [Transaction Management](#transaction-management)
-   [Payment Integration](#payment-integration)
-   [Error Handling](#error-handling)
-   [Webhook Events](#webhook-events)

## 🔐 Authentication

### Login

**Endpoint:** `POST /login`

**Request Body:**

```json
{
    "username": "kasir",
    "password": "kasir123"
}
```

**Response Success:**

```json
{
    "success": true,
    "message": "Login berhasil",
    "user": {
        "id": 1,
        "name": "Kasir",
        "username": "kasir",
        "email": "kasir@warungtm.com",
        "role": "kasir"
    },
    "redirect": "/kasir/dashboard"
}
```

### Logout

**Endpoint:** `POST /logout`

**Headers:**

```
X-CSRF-TOKEN: {csrf_token}
```

## 📊 Base Information

### Base URL

-   **Development:** `http://127.0.0.1:8000`
-   **Production:** `https://yourdomain.com`

### Content Type

-   **Request:** `application/json`
-   **Response:** `application/json`

### Authentication Method

-   **Web:** Session-based (Laravel Session)
-   **API:** Token-based (future implementation)

## 👥 User Management

### Get Current User

**Endpoint:** `GET /api/user`
**Auth:** Required

**Response:**

```json
{
    "id": 1,
    "name": "Kasir",
    "username": "kasir",
    "email": "kasir@warungtm.com",
    "role": "kasir",
    "created_at": "2025-11-05T10:00:00.000000Z"
}
```

## 🍽️ Menu Management

### Get All Menus

**Endpoint:** `GET /api/menus`
**Auth:** Required

**Query Parameters:**

-   `category` (optional): Filter by category
-   `available` (optional): Filter available items (true/false)

**Response:**

```json
{
    "success": true,
    "data": {
        "Makanan": [
            {
                "id": 1,
                "name": "Nasi Gudeg",
                "description": "Nasi gudeg dengan ayam dan telur",
                "price": 15000,
                "category": "Makanan",
                "is_available": true,
                "stock": 20,
                "created_at": "2025-11-05T10:00:00.000000Z"
            }
        ],
        "Minuman": [
            {
                "id": 5,
                "name": "Es Teh Manis",
                "description": "Es teh manis segar",
                "price": 3000,
                "category": "Minuman",
                "is_available": true,
                "stock": 50,
                "created_at": "2025-11-05T10:00:00.000000Z"
            }
        ]
    }
}
```

### Create Menu (Owner only)

**Endpoint:** `POST /owner/menu`
**Auth:** Required (Owner role)

**Request Body:**

```json
{
    "name": "Sate Ayam",
    "description": "Sate ayam dengan bumbu kacang",
    "price": 20000,
    "category": "Makanan",
    "stock": 15
}
```

**Response:**

```json
{
    "success": true,
    "message": "Menu berhasil ditambahkan",
    "data": {
        "id": 10,
        "name": "Sate Ayam",
        "description": "Sate ayam dengan bumbu kacang",
        "price": 20000,
        "category": "Makanan",
        "is_available": true,
        "stock": 15
    }
}
```

## 💰 Transaction Management

### Create Cash Transaction

**Endpoint:** `POST /kasir/transaksi`
**Auth:** Required (Kasir role)

**Request Body:**

```json
{
    "items": [
        {
            "menu_id": 1,
            "menu_name": "Nasi Gudeg",
            "menu_price": 15000,
            "quantity": 2,
            "subtotal": 30000,
            "notes": "Pedas"
        },
        {
            "menu_id": 5,
            "menu_name": "Es Teh Manis",
            "menu_price": 3000,
            "quantity": 1,
            "subtotal": 3000
        }
    ],
    "payment_method": "cash",
    "paid_amount": 35000,
    "notes": "Bungkus"
}
```

**Response:**

```json
{
  "success": true,
  "message": "Transaksi berhasil disimpan",
  "transaction": {
    "id": 123,
    "transaction_code": "TRX-20251105-0001",
    "user_id": 2,
    "total_amount": 33000,
    "total_items": 3,
    "payment_method": "cash",
    "paid_amount": 35000,
    "change_amount": 2000,
    "status": "completed",
    "notes": "Bungkus",
    "created_at": "2025-11-05T12:30:45.000000Z",
    "items": [...]
  }
}
```

### Get Transaction History

**Endpoint:** `GET /kasir/riwayat-transaksi`
**Auth:** Required (Kasir role)

**Query Parameters:**

-   `search` (optional): Search by transaction code
-   `date_from` (optional): Start date (Y-m-d format)
-   `date_to` (optional): End date (Y-m-d format)
-   `page` (optional): Page number for pagination

**Response:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 123,
                "transaction_code": "TRX-20251105-0001",
                "total_amount": 33000,
                "total_items": 3,
                "payment_method": "cash",
                "status": "completed",
                "created_at": "2025-11-05T12:30:45.000000Z",
                "user": {
                    "name": "Kasir"
                }
            }
        ],
        "total": 1,
        "per_page": 15,
        "last_page": 1
    },
    "summary": {
        "total_revenue": 33000,
        "average_transaction": 33000
    }
}
```

### Get Transaction Detail

**Endpoint:** `GET /kasir/transaksi/{id}/detail`
**Auth:** Required

**Response:**

```json
{
    "success": true,
    "transaction": {
        "id": 123,
        "transaction_code": "TRX-20251105-0001",
        "user_id": 2,
        "total_amount": 33000,
        "total_items": 3,
        "payment_method": "cash",
        "payment_status": "paid",
        "paid_amount": 35000,
        "change_amount": 2000,
        "status": "completed",
        "notes": "Bungkus",
        "created_at": "2025-11-05T12:30:45.000000Z",
        "user": {
            "id": 2,
            "name": "Kasir"
        },
        "items": [
            {
                "id": 245,
                "menu_id": 1,
                "menu_name": "Nasi Gudeg",
                "menu_price": 15000,
                "quantity": 2,
                "subtotal": 30000,
                "notes": "Pedas"
            }
        ]
    }
}
```

## 💳 Payment Integration

### Create QRIS Payment Token

**Endpoint:** `POST /kasir/create-payment-token`
**Auth:** Required (Kasir role)

**Request Body:**

```json
{
    "items": [
        {
            "menu_id": 1,
            "menu_name": "Nasi Gudeg",
            "menu_price": 15000,
            "quantity": 2
        }
    ],
    "total_amount": 30000,
    "notes": "Bungkus"
}
```

**Response:**

```json
{
    "success": true,
    "snap_token": "28d36b37-1d45-4b3b-a9ec-1f0e0e3f8c0e",
    "transaction": {
        "id": 124,
        "transaction_code": "TRX-20251105-0002",
        "midtrans_order_id": "ORDER-1730802645-2",
        "payment_status": "pending",
        "total_amount": 30000,
        "created_at": "2025-11-05T13:10:45.000000Z"
    }
}
```

### Check Payment Status

**Endpoint:** `GET /kasir/check-payment-status/{orderId}`
**Auth:** Required

**Response:**

```json
{
    "success": true,
    "transaction": {
        "id": 124,
        "payment_status": "paid",
        "status": "completed",
        "paid_amount": 30000,
        "updated_at": "2025-11-05T13:15:30.000000Z"
    },
    "midtrans_status": {
        "transaction_id": "28d36b37-1d45-4b3b-a9ec-1f0e0e3f8c0e",
        "transaction_status": "settlement",
        "gross_amount": "30000.00"
    }
}
```

### Midtrans Webhook Callback

**Endpoint:** `POST /midtrans-callback`
**Auth:** None (Public endpoint)

**Request Body (dari Midtrans):**

```json
{
    "order_id": "ORDER-1730802645-2",
    "status_code": "200",
    "gross_amount": "30000.00",
    "transaction_status": "settlement",
    "signature_key": "sha512_hash_signature",
    "payment_type": "qris",
    "transaction_time": "2025-11-05 13:15:30"
}
```

**Response:**

```json
{
    "message": "Callback processed successfully"
}
```

## ⚠️ Error Handling

### Error Response Format

```json
{
    "success": false,
    "message": "Error message description",
    "errors": {
        "field_name": ["Specific field error message"]
    },
    "code": "ERROR_CODE" // Optional
}
```

### HTTP Status Codes

| Code  | Description      |
| ----- | ---------------- |
| `200` | Success          |
| `201` | Created          |
| `400` | Bad Request      |
| `401` | Unauthorized     |
| `403` | Forbidden        |
| `404` | Not Found        |
| `422` | Validation Error |
| `500` | Server Error     |

### Common Error Examples

#### Validation Error (422):

```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "menu_id": ["The menu id field is required."],
        "quantity": ["The quantity must be at least 1."]
    }
}
```

#### Authentication Error (401):

```json
{
    "success": false,
    "message": "Unauthenticated.",
    "code": "UNAUTHENTICATED"
}
```

#### Authorization Error (403):

```json
{
    "success": false,
    "message": "Access denied. Owner role required.",
    "code": "ACCESS_DENIED"
}
```

#### Not Found Error (404):

```json
{
    "success": false,
    "message": "Transaction not found.",
    "code": "TRANSACTION_NOT_FOUND"
}
```

## 🔗 Webhook Events

### Midtrans Payment Events

#### Payment Success:

```json
{
    "event": "payment.success",
    "order_id": "ORDER-1730802645-2",
    "transaction_id": "28d36b37-1d45-4b3b-a9ec-1f0e0e3f8c0e",
    "gross_amount": "30000.00",
    "payment_type": "qris",
    "transaction_time": "2025-11-05 13:15:30"
}
```

#### Payment Pending:

```json
{
    "event": "payment.pending",
    "order_id": "ORDER-1730802645-2",
    "transaction_id": "28d36b37-1d45-4b3b-a9ec-1f0e0e3f8c0e",
    "gross_amount": "30000.00"
}
```

#### Payment Failed:

```json
{
    "event": "payment.failed",
    "order_id": "ORDER-1730802645-2",
    "transaction_id": "28d36b37-1d45-4b3b-a9ec-1f0e0e3f8c0e",
    "failure_reason": "Insufficient balance"
}
```

## 🧪 Testing

### Postman Collection

Import collection untuk testing API:

```bash
# Download Postman collection
curl -o warung-tm-api.json https://github.com/ipamungkas88/Kasir-warungTM/raw/main/docs/postman-collection.json
```

### Test Environment Variables

```json
{
    "base_url": "http://127.0.0.1:8000",
    "csrf_token": "{{$randomUUID}}",
    "user_token": ""
}
```

### Sample Test Requests

#### Test Login:

```bash
curl -X POST http://127.0.0.1:8000/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "kasir",
    "password": "kasir123"
  }'
```

#### Test Create Transaction:

```bash
curl -X POST http://127.0.0.1:8000/kasir/transaksi \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your_csrf_token" \
  -d '{
    "items": [
      {
        "menu_id": 1,
        "quantity": 2
      }
    ],
    "payment_method": "cash",
    "paid_amount": 30000
  }'
```

## 📚 SDK & Libraries

### JavaScript/TypeScript

```javascript
// Example using fetch API
const createTransaction = async (transactionData) => {
    const response = await fetch("/kasir/transaksi", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify(transactionData),
    });

    return response.json();
};
```

### PHP (cURL)

```php
<?php
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => 'http://127.0.0.1:8000/kasir/transaksi',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => json_encode([
    'items' => [
      ['menu_id' => 1, 'quantity' => 2]
    ],
    'payment_method' => 'cash',
    'paid_amount' => 30000
  ]),
  CURLOPT_HTTPHEADER => [
    'Content-Type: application/json',
    'X-CSRF-TOKEN: ' . $csrfToken
  ],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);
?>
```

---

## 📞 Support

Untuk pertanyaan API atau integrasi:

-   **GitHub Issues**: [API Issues](https://github.com/ipamungkas88/Kasir-warungTM/issues?q=is%3Aissue+label%3Aapi)
-   **Email**: api-support@warungtm.com
-   **Documentation**: [Wiki](https://github.com/ipamungkas88/Kasir-warungTM/wiki/API-Documentation)

**Last Updated:** November 5, 2025  
**API Version:** 1.0
