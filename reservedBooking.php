<!-- Previous PHP code remains the same -->
<?php
    include_once '../model/BookingModel.php';
    include_once '../model/Booking_Model.php';

    $model = new BookingModel();
    $bookingModel = new Booking_Model();

    // Get all services
    $services = $bookingModel->get_service();

    // Include the Connector class
    require_once '../model/server.php';
    $connector = new Connector();

    // Fetch all bookings that are pending approval
    $sql = "SELECT booking_id, booking_fullname, booking_email, booking_number, booking_date FROM booking_tb WHERE booking_status = 'pending'";
    $bookings = $connector->executeQuery($sql);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $date = $_POST['date'];
        $service_id = $_POST['service_id'];  // Get the selected service ID from the form

        // Attempt to insert the booking
        $result = $bookingModel->insert_booking($fullname, $email, $number, $date, $service_id);

        if ($result === true) {
            echo "Booking successfully added!";
        } else {
            echo $result;  // Display error message if any
        }
    }
?>
<section id="services" class="services section d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="service-list">
                    <?php if (!empty($services)): ?>
                        <div class="service-item text-center">
                            <h3><?= $services[0]['services_name'] ?></h3>
                            <img src="../images/<?= $services[0]['services_image'] ?>" 
                                 alt="<?= $services[0]['services_name'] ?>" 
                                 class="service-image img-fluid mx-auto d-block" 
                                 style="max-width: 2000px; height: 70%; margin-left: 450px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <p class="description text-center"><?= $services[0]['services_description'] ?></p>
                            <div class="service-price mb-3">
                                $<?= number_format($services[0]['services_price'], 2) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="booking-form mx-auto" style="max-width: 600px; margin: 0 auto; padding: 20px; background: #f8f9fa; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <form action="../pages/submit-booking.php" method="POST">
                        <input type="hidden" name="service_id" value="<?= $selected_service['services_id'] ?>" />
                        
                        <div class="mb-3">
                            <label for="fullname" class="form-label fw-bold">Full Name:</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="number" class="form-label fw-bold">Phone Number:</label>
                            <input type="text" name="number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="service" class="form-label fw-bold">Selected Service:</label>
                            <input type="text" name="service" class="form-control" value="<?= $selected_service['services_name'] ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label fw-bold">Booking Date:</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
