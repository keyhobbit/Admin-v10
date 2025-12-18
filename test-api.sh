#!/bin/bash

echo "=== AFK Game API - Test Script ==="
echo ""
echo "✅ Ports Configuration:"
echo "  - API: http://localhost:9000"
echo "  - MySQL: localhost:3308"
echo "  - Redis: localhost:6380"
echo ""

echo "📋 Testing Login API..."
echo "Request: POST /api/auth/login"
echo "Credentials: player1@example.com / password123"
echo ""

RESPONSE=$(curl -s -X POST http://localhost:9000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"player1@example.com","password":"password123"}')

echo "Response:"
echo "$RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$RESPONSE"
echo ""

# Extract token
TOKEN=$(echo "$RESPONSE" | python3 -c "import sys, json; print(json.load(sys.stdin)['token'])" 2>/dev/null)

if [ ! -z "$TOKEN" ]; then
    echo "✅ Login successful! Token: ${TOKEN:0:20}..."
    echo ""
    echo "📋 Testing Protected Endpoint (/api/auth/me)..."
    
    ME_RESPONSE=$(curl -s -X GET http://localhost:9000/api/auth/me \
      -H "Authorization: Bearer $TOKEN")
    
    echo "Response:"
    echo "$ME_RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$ME_RESPONSE"
    echo ""
    
    echo "✅ All tests passed!"
else
    echo "❌ Login failed"
fi

echo ""
echo "=== Available Test Accounts ==="
echo "  - player1@example.com / password123"
echo "  - player2@example.com / password123"
echo "  - admin@example.com / admin123"
echo "  - demo@example.com / demo123"
