<?php
include_once('./dbCon.php');
function getSchedules()
{
    global $conn;
    $sql = "SELECT * FROM tbl_appointments ORDER BY date, time DESC";
    $result = $conn->query($sql);

    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    return $schedules;
}

function searchSchedules($query)
{
    global $conn;
    $query = "%" . $conn->real_escape_string($query) . "%";
    $sql = "SELECT * FROM tbl_appointments 
            WHERE name LIKE ? OR address LIKE ? OR contact LIKE ? 
            ORDER BY date, time DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    return $schedules;
}

function getScheduleById($id)
{
    global $conn;
    $sql = "SELECT * FROM tbl_appointments WHERE a_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function getAllPayments()
{
    global $conn;

    $sql = "SELECT t.payment_intent_id, t.status, t.user_id, u.name, u.username, t.total, t.date
            FROM tbl_transactions t
            INNER JOIN tbl_users u ON u.uID = t.user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $payments = [];

        while ($row = $result->fetch_assoc()) {
            $payments[] = [
                'payment_intent_id' => $row['payment_intent_id'],
                'status' => $row['status'],
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'username' => $row['username'],
                'total' => $row['total'],
                'date' => $row['date']
            ];
        }

        return $payments;
    } else {
        return [];
    }
}

function getAppointmentsCountByMonth()
{
    global $conn;
    $sql = "SELECT MONTH(date) AS month, COUNT(DISTINCT a_id) AS appointments_count
            FROM tbl_appointments
            GROUP BY MONTH(date)
            ORDER BY MONTH(date)";

    $result = $conn->query($sql);

    $appointments = array_fill(1, 12, 0);
    while ($row = $result->fetch_assoc()) {
        $appointments[$row['month']] = $row['appointments_count'];
    }

    return $appointments;
}

function getRevenueByMonth()
{
    global $conn;
    $sql = "SELECT MONTH(date) AS month, SUM(total) AS revenue
            FROM tbl_transactions
            GROUP BY MONTH(date)
            ORDER BY MONTH(date)";

    $result = $conn->query($sql);

    $revenue = array_fill(1, 12, 0);
    while ($row = $result->fetch_assoc()) {
        $revenue[$row['month']] = $row['revenue'];
    }

    return $revenue;
}

function getActiveUsers()
{
    global $conn;
    $sql = "SELECT COUNT(DISTINCT u.uID) AS active_users 
            FROM tbl_appointments a
            JOIN tbl_users u ON a.username = u.username
            WHERE u.uID IN (
                SELECT DISTINCT user_id FROM tbl_carts
                UNION
                SELECT DISTINCT user_id FROM tbl_transactions
            )";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['active_users'];
}

function closeConnection()
{
    global $conn;
    $conn->close();
}