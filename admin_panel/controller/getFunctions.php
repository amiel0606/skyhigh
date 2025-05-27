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

function getWalkInAppointments()
{
    global $conn; 
    $query = "SELECT * FROM tbl_appointments WHERE type = 'Walk-in'";
    $result = mysqli_query($conn, $query);
    $appointments = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }

    return $appointments;
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

function getAllBrands()
{
    global $conn;
    $sql = "SELECT * FROM tbl_brands ORDER BY brand_name ASC";
    $result = $conn->query($sql);

    $brands = [];
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }
    return $brands;
}

function getBrandById($id)
{
    global $conn;
    $sql = "SELECT * FROM tbl_brands WHERE b_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAppointmentsCountByWeek()
{
    global $conn;
    $sql = "SELECT YEAR(date) AS year, WEEK(date, 1) AS week, COUNT(DISTINCT a_id) AS appointments_count
            FROM tbl_appointments
            GROUP BY YEAR(date), WEEK(date, 1)
            ORDER BY YEAR(date), WEEK(date, 1)";

    $result = $conn->query($sql);

    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $key = $row['year'] . '-W' . str_pad($row['week'], 2, '0', STR_PAD_LEFT);
        $appointments[$key] = $row['appointments_count'];
    }

    return $appointments;
}

function getRevenueByWeek()
{
    global $conn;
    $sql = "SELECT YEAR(date) AS year, WEEK(date, 1) AS week, SUM(total) AS revenue
            FROM tbl_transactions
            GROUP BY YEAR(date), WEEK(date, 1)
            ORDER BY YEAR(date), WEEK(date, 1)";

    $result = $conn->query($sql);

    $revenue = [];
    while ($row = $result->fetch_assoc()) {
        $key = $row['year'] . '-W' . str_pad($row['week'], 2, '0', STR_PAD_LEFT);
        $revenue[$key] = $row['revenue'];
    }

    return $revenue;
}

function getAppointmentsCountByDayOfWeek()
{
    global $conn;
    $sql = "SELECT DAYOFWEEK(date) AS day, COUNT(DISTINCT a_id) AS appointments_count
            FROM tbl_appointments
            GROUP BY DAYOFWEEK(date)
            ORDER BY DAYOFWEEK(date)";

    $result = $conn->query($sql);

    $appointments = array_fill(1, 7, 0);
    while ($row = $result->fetch_assoc()) {
        $appointments[$row['day']] = $row['appointments_count'];
    }

    return $appointments;
}

function getRevenueByDayOfWeek()
{
    global $conn;
    $sql = "SELECT DAYOFWEEK(date) AS day, SUM(total) AS revenue
            FROM tbl_transactions
            GROUP BY DAYOFWEEK(date)
            ORDER BY DAYOFWEEK(date)";

    $result = $conn->query($sql);

    $revenue = array_fill(1, 7, 0); // 1=Sunday, 7=Saturday
    while ($row = $result->fetch_assoc()) {
        $revenue[$row['day']] = $row['revenue'];
    }

    return $revenue;
}

// New Analytics Functions
function getTotalOrders()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total_orders FROM tbl_transactions WHERE status = 'Paid'";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_orders'];
}

function getTotalRevenue()
{
    global $conn;
    $sql = "SELECT SUM(total) AS total_revenue FROM tbl_transactions WHERE status = 'Paid'";
    $result = $conn->query($sql);
    $revenue = $result->fetch_assoc()['total_revenue'];
    return $revenue ? $revenue : 0;
}

function getTopSellingItem()
{
    global $conn;
    $sql = "SELECT c.product_name, SUM(c.quantity) AS total_sold
            FROM tbl_carts c
            INNER JOIN tbl_transactions t ON c.transID = t.payment_intent_id
            WHERE t.status = 'Paid'
            GROUP BY c.product_name
            ORDER BY total_sold DESC
            LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row ? $row['product_name'] : 'No sales yet';
}

function getTopService()
{
    global $conn;
    $sql = "SELECT service, COUNT(*) AS service_count
            FROM tbl_appointments
            WHERE status IN ('Confirmed', 'Completed')
            GROUP BY service
            ORDER BY service_count DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 0) {
        return ['services' => [], 'message' => 'No appointments yet'];
    }
    
    $services = [];
    $topCount = null;
    
    while ($row = $result->fetch_assoc()) {
        if ($topCount === null) {
            $topCount = $row['service_count'];
        }
        
        // Only include services that have the same count as the top service
        if ($row['service_count'] == $topCount) {
            $services[] = $row['service'];
        } else {
            break; // Stop when we reach services with lower counts
        }
    }
    
    return ['services' => $services, 'count' => $topCount];
}

function getMostScheduledTime()
{
    global $conn;
    $sql = "SELECT time, COUNT(*) AS time_count
            FROM tbl_appointments
            WHERE status IN ('Confirmed', 'Completed')
            GROUP BY time
            ORDER BY time_count DESC
            LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row ? $row['time'] : 'No appointments yet';
}

function getMostScheduledDay()
{
    global $conn;
    $sql = "SELECT DAYNAME(STR_TO_DATE(date, '%Y-%m-%d')) AS day_name, COUNT(*) AS day_count
            FROM tbl_appointments
            WHERE status IN ('Confirmed', 'Completed')
            GROUP BY DAYOFWEEK(STR_TO_DATE(date, '%Y-%m-%d'))
            ORDER BY day_count DESC
            LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row ? $row['day_name'] : 'No appointments yet';
}

function getTotalAppointments()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total_appointments FROM tbl_appointments";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_appointments'];
}

function getActiveUsersCount()
{
    global $conn;
    $sql = "SELECT COUNT(DISTINCT u.uID) AS active_users 
            FROM tbl_users u
            WHERE u.uID IN (
                SELECT DISTINCT user_id FROM tbl_carts
                UNION
                SELECT DISTINCT user_id FROM tbl_transactions
                UNION
                SELECT DISTINCT u2.uID FROM tbl_appointments a 
                INNER JOIN tbl_users u2 ON a.username = u2.username
            )";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['active_users'];
}

function getWalkInAppointmentsCount()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS walkin_count FROM tbl_appointments WHERE type = 'Walk-in'";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['walkin_count'];
}

function getTotalRevenueAllMonths()
{
    global $conn;
    $sql = "SELECT SUM(total) AS total_revenue FROM tbl_transactions";
    $result = $conn->query($sql);
    $revenue = $result->fetch_assoc()['total_revenue'];
    return $revenue ? $revenue : 0;
}

function getTotalAppointmentsAllMonths()
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total_appointments FROM tbl_appointments";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_appointments'];
}