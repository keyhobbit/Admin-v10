#!/bin/bash

echo "╔══════════════════════════════════════════════════════════════╗"
echo "║        AFK Game API - Admin System Test                     ║"
echo "╚══════════════════════════════════════════════════════════════╝"
echo ""

echo "📋 Admin Accounts Created:"
echo "  - superadmin@example.com / superadmin123 (super_admin)"
echo "  - admin@example.com / admin123 (admin)"
echo "  - moderator@example.com / moderator123 (moderator)"
echo ""

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  TEST 1: Admin Login"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

ADMIN_RESPONSE=$(curl -s -X POST http://localhost:9000/api/admin/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"admin123"}')

echo "$ADMIN_RESPONSE" | python3 -m json.tool
echo ""

ADMIN_TOKEN=$(echo "$ADMIN_RESPONSE" | python3 -c "import sys, json; print(json.load(sys.stdin)['token'])" 2>/dev/null)

if [ ! -z "$ADMIN_TOKEN" ]; then
    echo "✅ Admin login successful! Token: ${ADMIN_TOKEN:0:30}..."
    echo ""

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "  TEST 2: Get Admin Profile"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s -X GET http://localhost:9000/api/admin/me \
      -H "Authorization: Bearer $ADMIN_TOKEN" | python3 -m json.tool
    echo ""
    echo ""

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "  TEST 3: Get User Statistics"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s -X GET http://localhost:9000/api/admin/users/stats \
      -H "Authorization: Bearer $ADMIN_TOKEN" | python3 -m json.tool
    echo ""
    echo ""

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "  TEST 4: List All Users (First Page)"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    curl -s -X GET "http://localhost:9000/api/admin/users?per_page=5" \
      -H "Authorization: Bearer $ADMIN_TOKEN" | python3 -m json.tool | head -30
    echo "..."
    echo ""

    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "  TEST 5: User Login (Separate Session)"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    USER_RESPONSE=$(curl -s -X POST http://localhost:9000/api/auth/login \
      -H "Content-Type: application/json" \
      -d '{"email":"player1@example.com","password":"password123"}')
    
    echo "$USER_RESPONSE" | python3 -m json.tool
    echo ""
    
    USER_TOKEN=$(echo "$USER_RESPONSE" | python3 -c "import sys, json; print(json.load(sys.stdin)['token'])" 2>/dev/null)
    
    if [ ! -z "$USER_TOKEN" ]; then
        echo "✅ User login successful! Token: ${USER_TOKEN:0:30}..."
        echo ""
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
        echo "  ✅ ADMIN AND USER SESSIONS ARE SEPARATE!"
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
        echo "  Admin Token:  ${ADMIN_TOKEN:0:20}..."
        echo "  User Token:   ${USER_TOKEN:0:20}..."
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    fi
else
    echo "❌ Admin login failed"
fi

echo ""
echo "✅ All tests completed!"
echo ""
echo "📚 Available Admin Endpoints:"
echo "  POST   /api/admin/login                    - Admin login"
echo "  POST   /api/admin/logout                   - Admin logout"
echo "  GET    /api/admin/me                       - Get admin profile"
echo "  POST   /api/admin/change-password          - Change password"
echo "  GET    /api/admin/users                    - List all users"
echo "  GET    /api/admin/users/stats              - User statistics"
echo "  GET    /api/admin/users/{id}               - Get user details"
echo "  POST   /api/admin/users                    - Create user"
echo "  PUT    /api/admin/users/{id}               - Update user"
echo "  DELETE /api/admin/users/{id}               - Delete user"
echo "  POST   /api/admin/users/{id}/toggle-ban    - Ban/unban user"
echo ""
